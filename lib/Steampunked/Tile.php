<?php
/**
 * Created by PhpStorm.
 * User: MatthewWiechec
 * Date: 2/9/16
 * Time: 7:46 PM
 */

namespace Steampunked;


class Tile {
    // Differnt types of pieces
    const START_PIECE = 'start_piece';
    const END_PIECE = 'end_piece';
    const END_PIECE_TOP = 'end_piece_top';
    const CAP = 'cap';
    const LEAK = 'leak';
    const NINETY = 'ninety';
    const TEE = 'tee';
    const STRAIGHT = 'STRAIGHT';

    // Different orientations in degrees
    const ZERO_ROTATION = '0_rotation';
    const NINETY_ROTATION = '90_rotation';
    const HALF_ROTATION = '180_rotation';
    const TWO_SEVENTY_ROTATION = '270_rotation';


    // The type of pipe contained in this tile. If null then no pipe is in this tile
    private $pieceType;

    // The rotation of the pipe
    private $rotation;

    // The person this tile belongs to.
    private $owner;

    public function __construct($piece = null, $rotation = tile::ZERO_ROTATION) {
        $this->pieceType = $piece;
        $this->rotation = $rotation;
    }

    /**
     * @return string returns the string of the image file used to display the pipe. Any case that calls a function
     * must determine the rotation and return the image based on that
     */
    public function getPieceImage() {
        switch ($this->pieceType) {
            case $this::START_PIECE:
                return 'valve-closed.png';
            case $this::END_PIECE:
                return 'gauge-190.png';
            case $this::END_PIECE_TOP:
                return 'gauge-top-0.png';
            case $this::CAP:
                return $this->capImage();
            case $this::LEAK:
                return $this->leakImage();
            case $this::NINETY:
                return $this->ninetyImage();
            case $this::TEE:
                return $this->teeImage();
            case $this::STRAIGHT:
                return $this->straightImage();
            default:
                // The piece for the tile has not been set
                return null;
        }
    }

    private function capImage() {
        switch ($this->rotation) {
            case $this::ZERO_ROTATION:
                return 'cap-s.png';
            case $this::NINETY_ROTATION:
                return 'cap-w.png';
            case $this::HALF_ROTATION:
                return 'cap-n.png';
            case $this::TWO_SEVENTY_ROTATION:
                return 'cap-e.png';
        }
    }

    private function leakImage() {
        switch ($this->rotation) {
            case $this::ZERO_ROTATION:
                return 'leak-s.png';
            case $this::NINETY_ROTATION:
                return 'leak-w.png';
            case $this::HALF_ROTATION:
                return 'leak-n.png';
            case $this::TWO_SEVENTY_ROTATION:
                return 'leak-e.png';
        }
    }

    private function ninetyImage() {
        switch ($this->rotation) {
            case $this::ZERO_ROTATION:
                return 'ninety-es.png';
            case $this::NINETY_ROTATION:
                return 'ninety-sw.png';
            case $this::HALF_ROTATION:
                return 'ninety-wn.png';
            case $this::TWO_SEVENTY_ROTATION:
                return 'ninety-ne.png';
        }
    }

    private function teeImage() {
        switch ($this->rotation) {
            case $this::ZERO_ROTATION:
                return 'tee-esw.png';
            case $this::NINETY_ROTATION:
                return 'tee-swn.png';
            case $this::HALF_ROTATION:
                return 'tee-wne.png';
            case $this::TWO_SEVENTY_ROTATION:
                return 'tee-nes.png';
        }
    }

    private function straightImage() {
        switch ($this->rotation) {
            case $this::ZERO_ROTATION:
                return 'straight-h.png';
            case $this::NINETY_ROTATION:
                return 'straight-v.png';
            case $this::HALF_ROTATION:
                return 'straight-h.png';
            case $this::TWO_SEVENTY_ROTATION:
                return 'straight-v.png';
        }
    }

    public function getPieceType() {
        return $this->pieceType;
    }

    public function getRotation() {
        return $this->rotation;
    }

    public function getOwnership() {
        return $this->owner;
    }

    public function setOwnership($owner) {
        $this->owner = $owner;
    }

    public function setRotation($rotation) {
        $this->rotation = $rotation;
    }

    public function rotatePiece() {
        switch ($this->rotation) {
            case $this::ZERO_ROTATION:
                $this->rotation = $this::NINETY_ROTATION;
                break;
            case $this::NINETY_ROTATION:
                $this->rotation = $this::HALF_ROTATION;
                break;
            case $this::HALF_ROTATION:
                $this->rotation = $this::TWO_SEVENTY_ROTATION;
                break;
            case $this::TWO_SEVENTY_ROTATION:
                $this->rotation = $this::ZERO_ROTATION;
                break;
        }
    }

    /**
     * @param $opening Check if there is an opening on this side of the piece
     * 0 - North, 1 - East, 2 - South, 3 - West
     */
    public function checkOpening($opening) {
        //
        // Special cases for opening piece, end piece, and straight piece
        //
        if ($this->pieceType == $this::START_PIECE) {
            if ($opening == 1) {
                return true;
            } else {
                return false;
            }
        }

        if ($this->pieceType == $this::END_PIECE || $this->pieceType == $this::END_PIECE_TOP) {
            return false;
        }

        if ($this->pieceType == $this::STRAIGHT) {
            $pieceString = $this->getPieceImage();
            if ($pieceString == 'straight-h.png') {
                if ($opening == 1 || $opening == 3) {
                    return true;
                } else {
                    return false;
                }
            } else {
                if ($opening == 0 || $opening == 2) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        $pieceString = $this->getPieceImage();

        if ($pieceString == null) {
            return false;
        }

        $directions = $this->getOpenings($pieceString);

        switch ($opening) {
            case 0:
                if (strpos($directions, 'n') !== false) {
                    return true;
                } else {
                    return false;
                }
            case 1:
                if (strpos($directions, 'e') !== false) {
                    return true;
                } else {
                    return false;
                }
            case 2:
                if (strpos($directions, 's') !== false) {
                    return true;
                } else {
                    return false;
                }
            case 3:
                if (strpos($directions, "w") !== false) {
                    return true;
                } else {
                    return false;
                }
        }
    }

    private function getOpenings($pieceString) {
        $explodedStringArray = explode('-', $pieceString);
        $explodedString = $explodedStringArray[1];
        $directions = explode('.', $explodedString);
        return $directions[0];
    }
}