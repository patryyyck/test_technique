<?php

namespace Fulll\Domain;

class Location
{
    /**
     * Initializes a new instance of the Location class.
     *
     * @param float      $_lat The latitude coordinate.
     * @param float      $_lng The longitude coordinate.
     * @param float|null $_alt The altitude coordinate.
     */
    public function __construct(
        private float $_lat,
        private float $_lng,
        private ?float $_alt
    ) {
    }

    /**
     * Gets the latitude coordinate.
     *
     * @return float The latitude coordinate.
     */
    public function getLat(): float
    {
        return $this->_lat;
    }

    /**
     * Sets the latitude coordinate.
     *
     * @param float $lat The latitude coordinate.
     * 
     * @return void
     */
    public function setLat(float $lat): void
    {
        $this->_lat = $lat;
    }

    /**
     * Gets the longitude coordinate.
     *
     * @return float The longitude coordinate.
     */
    public function getLng(): float
    {
        return $this->_lng;
    }

    /**
     * Sets the longitude coordinate.
     *
     * @param float $lng The longitude coordinate.
     * 
     * @return void
     */
    public function setLng(float $lng): void
    {
        $this->_lng = $lng;
    }

    /**
     * Gets the altitude coordinate.
     *
     * @return float|null The altitude coordinate.
     */
    public function getAlt(): ?float
    {
        return $this->_alt;
    }

    /**
     * Sets the altitude coordinate.
     *
     * @param float $alt The altitude coordinate.
     * 
     * @return void
     */
    public function setAlt(float $alt): void
    {
        $this->_alt = $alt;
    }
}
