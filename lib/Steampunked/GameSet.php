<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 4/14/16
 * Time: 9:49 PM
 */

namespace Steampunked;


class GameSet
{
    private $id;
    private $xLoc;
    private $yLoc;
    private $Gameid;
    private $Rotation;
    private $Type;
    private $Ownership;

    /**
     * Constructor
     * @param $row Row from the user table in the database
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->xLoc = $row['xLoc'];
        $this->yLoc = $row['yLoc'];
        $this->Gameid = $row['Gameid'];
        $this->Rotation = $row['Rotation'];
        $this->Type = $row['Type'];
        $this->Ownership = $row['Ownership'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getXLoc()
    {
        return $this->xLoc;
    }

    /**
     * @param mixed $xLoc
     */
    public function setXLoc($xLoc)
    {
        $this->xLoc = $xLoc;
    }

    /**
     * @return mixed
     */
    public function getYLoc()
    {
        return $this->yLoc;
    }

    /**
     * @param mixed $yLoc
     */
    public function setYLoc($yLoc)
    {
        $this->yLoc = $yLoc;
    }

    /**
     * @return mixed
     */
    public function getGameid()
    {
        return $this->Gameid;
    }

    /**
     * @param mixed $Gameid
     */
    public function setGameid($Gameid)
    {
        $this->Gameid = $Gameid;
    }

    /**
     * @return mixed
     */
    public function getRotation()
    {
        return $this->Rotation;
    }

    /**
     * @param mixed $Rotation
     */
    public function setRotation($Rotation)
    {
        $this->Rotation = $Rotation;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->Type;
    }

    /**
     * @param mixed $Type
     */
    public function setType($Type)
    {
        $this->Type = $Type;
    }

    /**
     * @return mixed
     */
    public function getOwnership()
    {
        return $this->Ownership;
    }

    /**
     * @param mixed $Ownership
     */
    public function setOwnership($Ownership)
    {
        $this->Ownership = $Ownership;
    }
}