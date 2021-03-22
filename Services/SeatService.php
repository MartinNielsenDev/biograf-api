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
        $model->setLocation($array['location']);
        $model->setTheaterId($array['theaterId']);
        $model->setTicketId($array['ticketId']);
        $model->setIsBooked($array['isBooked']);

        return $model;
    }

    public function getSeats(): array
    {
        return $this->query_service->selectRecords
        (
            seats::class,
            'SELECT id, location, theaterId, ticketId, isBooked FROM seats'
        );
    }

    public function putSeat(array $array): ?Seat
    {
        $seat = $this->toModel($array);
        $seat->setIsBooked($seat->getTicketId() !== null);

        /** @var seats $old_seat */
        $old_seat = $this->query_service->selectRecord(seats::class, 'SELECT location, theaterId, ticketId FROM seats WHERE id = ?', [$seat->getId()]);

        if ($old_seat === null) {
            return null;
        }
        $seat->setId($old_seat->id);
        $seat->setLocation($old_seat->location);
        $seat->setTheaterId($old_seat->threaterId);

        if ($this->query_service->updateRecord
        (
            Seat::class,
            'UPDATE seats SET ticketId = ?, isBooked = ? WHERE id = ?',
            [$seat->getTicketId(), $seat->isBooked(), $seat->getId()]
        )) {
            return $seat;
        }
        return null;
    }
}
