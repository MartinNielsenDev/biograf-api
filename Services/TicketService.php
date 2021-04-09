<?php

namespace Services;

use Lib\CurrentUser;
use Models\MovieShow;
use Models\MovieTicket;
use Models\Ticket;
use Models\TicketSeat;
use mysqli_sql_exception;
use Records\tickets;
use Records\users;

class TicketService
{
    /** @var QueryService */
    private $query_service;

    public function __construct(QueryService $query_service)
    {
        $this->query_service = $query_service;
    }

    private function toModel(array $array): Ticket
    {
        $model = new Ticket();
        $model->setId($array['id']);
        $model->setIsPaid($array['isPaid']);
        $model->setUserId($array['userId']);
        $model->setShow($array['show']);
        $model->setSeats($array['seats']);

        return $model;
    }

    public function createTicket(array $array): ?Ticket
    {
        if (!isset($array['id']) || !isset($array['isPaid']) || !isset($array['userId']) || !isset($array['show']) || !isset($array['seats'])) {
            return null;
        }
        $ticket = $this->toModel($array);

        try {
            $this->query_service->beginTransaction();

            /** @var users|null $user */
            $user = $this->query_service->selectRecord(
                users::class,
                'SELECT id, email, password, name, address, postCodeId, phoneNumber, privileges FROM users WHERE users.email = ?',
                [CurrentUser::$current_user->getEmail()]
            );

            if ($user === null) {
                throw new mysqli_sql_exception();
            }
            /** @var Ticket|null $ticket */
            $ticket_id = $this->query_service->insertRecord(
                'INSERT INTO tickets(isPaid, userId, showId) VALUES (?, ?, ?)',
                [$ticket->isPaid(), $user->id, $ticket->getShow()]
            );
            if ($ticket_id !== null) {
                $ticket->setId($ticket_id);

                foreach ($ticket->getSeats() as $seat_id) {
                    $inserted = $this->query_service->insertRecord(
                        'INSERT INTO ticketseats(ticketid, seatid) VALUES (?, ?)',
                        [$ticket_id, $seat_id]
                    );

                    if ($inserted === null) {
                        throw new mysqli_sql_exception();
                    }
                }
                $this->query_service->commit();
                return $ticket;
            }
        } catch (mysqli_sql_exception $exception) {
            $this->query_service->rollback();
        }
        $this->query_service->rollback();
        return null;
    }

    public function getTicket($ticket_id): ?Ticket
    {
        /** @var Ticket|null $user */
        $user = $this->query_service->selectRecord
        (
            Ticket::class,
            'SELECT tickets.id, tickets.isPaid, tickets.userId FROM tickets WHERE tickets.id = ?',
            [$ticket_id]
        );
        return $user;
    }

    public function getTickets(): array
    {
        /** @var tickets[] $tickets */
        $tickets = $this->query_service->selectRecords
        (
            tickets::class,
            'SELECT tickets.id, tickets.isPaid, tickets.userId, tickets.showId FROM tickets, users WHERE tickets.userId = users.id && users.email = ?',
            [CurrentUser::$current_user->getEmail()]
        );
        $nTickets = [];
        foreach ($tickets as $ticket) {
            $nTicket = new MovieTicket();
            $nTicket->setId($ticket->id);
            $nTicket->setUserId($ticket->userId);
            $nTicket->setIsPaid($ticket->isPaid);

            /** @var TicketSeat[] $ticketSeats */
            $ticketSeats = $this->query_service->selectRecords
            (
                TicketSeat::class,
                'SELECT id, ticketId, seatId FROM ticketseats WHERE ticketseats.ticketId = ?',
                [$nTicket->getId()]
            );
            $seats = [];

            foreach ($ticketSeats as $seat) {
                $seats[] = $seat->getId();
            }
            $nTicket->setSeats($seats);

            /** @var MovieShow $movieShow */
            $movieShow = $this->query_service->selectRecord
            (
                MovieShow::class,
                'SELECT shows.time, movies.title, movies.length, theaters.name AS theater FROM shows, movies, theaters WHERE shows.movieId = movies.id && shows.theaterId = theaters.id && shows.id = ?',
                [$ticket->showId]
            );

            if ($movieShow === null) {
                continue;
            }

            $nTicket->setShow($movieShow);

            $nTickets[] = $nTicket;
        }
        return $nTickets;
    }

    public function deleteTicket(int $user_id): ?int
    {
        return $this->query_service->deleteRecord('tickets', $user_id);
    }
}
