<?php

namespace Services;

use Models\Seat;
use Records\seats;

class SeatService
{
    /** @var QueryService */
    private $query_service;

    public function __construct(QueryService $query_service)
    {
        $this->query_service = $query_service;
    }

    private function toModel(array $array): Seat
    {
        $model = new Seat();
        $model->setId($array['id']);
        $model->setX($array['x']);
        $model->setY($array['y']);
        $model->setTheaterId($array['theaterId']);
        $model->setIsReserved($array['isReserved']);

        return $model;
    }

    public function getSeats(string $show, string $theater): array
    {
        $theaterId = null;
        $showId = intval($show);
        $theaterId = intval($theater);

        $records = $this->query_service->selectRecords
        (
            seats::class,
            'SELECT seats.id, seats.x, seats.y, seats.theaterId, EXISTS(SELECT * FROM ticketseats, shows, tickets WHERE ticketseats.seatId = seats.id && ticketseats.ticketId = tickets.id && tickets.showId = ?) AS isReserved FROM seats WHERE seats.theaterId = ?',
            [$showId, $theaterId]
        );
        $seats = [];
        foreach ($records as $seat) {
            $seats[] = $this->toModel((array)$seat);
        }
        return $seats;
    }

    public function putSeat(array $array): ?Seat
    {
//        $seat = $this->toModel($array);
//        $seat->setIsReserved($seat->getTicketId() !== null);
//
//        /** @var seats $old_seat */
//        $old_seat = $this->query_service->selectRecord(seats::class, 'SELECT x, y, theaterId FROM seats WHERE id = ?', [$seat->getId()]);
//
//        if ($old_seat === null) {
//            return null;
//        }
//        $seat->setId($old_seat->id);
//        $seat->setX($old_seat->x);
//        $seat->setY($old_seat->y);
//        $seat->setTheaterId($old_seat->threaterId);
//
//        if ($this->query_service->updateRecord
//        (
//            Seat::class,
//            'UPDATE seats SET ticketId = ?, isBooked = ? WHERE id = ?',
//            [$seat->getTicketId(), $seat->isReserved(), $seat->getId()]
//        )) {
//            return $seat;
//        }
//        return null;
    }
}
