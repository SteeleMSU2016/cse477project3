<?php
/**
 * Created by PhpStorm.
 * User: MatthewWiechec
 * Date: 2/9/16
 * Time: 7:17 PM
 */

namespace Steampunked;

//include "../site.inc.php";

class Steampunked {

    // The possible board sizes the game can be
    const POSSIBLE_BOARD_SIZES = array(6, 10, 20);

    //
    // The min and max a value can be when generating a pipe
    //
    const MIN = 1;
    const MAX = 4;

    //
    // Used to determine whos turn it is
    //
    const PLAYER1 = 'player1';
    const PLAYER2 = 'player2';

    // Number used to generate game pieces
    private $seed;

    // The actual board and what it contains
    private $board;

    // The board size of the game
    private $boardSize;

    // The current players turn
    private $playersTurn;

    //
    // The players
    //
    private $player1;
    private $player2;

    private $winner;
    private $gameOver = false;

    /**
     * Constructor
     *
     * @param null $seed Seed used to generate game pieces
     */
    public function __construct($seed = null) {
        if($seed === null) {
            $seed = time();
        }

        $this->seed = $seed;
        srand($this->seed);

        // Set the turn to player 1
        $this->playersTurn = $this::PLAYER1;
    }

    /**
     * @param $boardSize The size of the board
     * @param $player1 The name of player 1
     * @param $player2 The name of player 2
     * @return bool false if the game could not be initialized
     */
    public function initGame($boardSize, $player1, $player2) {
        $this->gameOver = false;

        // Check if the board is a valid size
        if (is_nan($boardSize) || !in_array($boardSize, $this::POSSIBLE_BOARD_SIZES)) {
            return false;
        }

        // The board size is valid so we can set it
        $this->boardSize = $boardSize;

        $this->player1 = new Player($player1);
        $this->player1->setPlayerNumber('1');
        $this->player2 = new Player($player2);
        $this->player2->setPlayerNumber('2');

        // The board size is valid so we can initialize the board
        $this->initBoard();

        $player1Pipes = $this->initPlayerPipes($this->player1);
        $this->player1->setInitialPipes($player1Pipes);
        $player2Pipes = $this->initPlayerPipes($this->player2);
        $this->player2->setInitialPipes($player2Pipes);
        return true;
    }

    public function getPlayer1(){
        return $this->player1;
    }

    public function getPlayer2(){
        return $this->player2;
    }

    public function setPlayer1($player){
        $this->player1 = $player;
    }

    public function setPlayer2($player){
        $this->player2 = $player;
    }

    public function setTurn($num){
        if ($num == 1) {
            $this->playersTurn = $this::PLAYER1;
        } else {
            $this->playersTurn = $this::PLAYER2;
        }
    }

    private function initPlayerPipes($player) {
        $playerPipes = array();

        for($i = 0; $i < 5; $i++) {
            $tile = $this->generateNewTile();
            $tile->setOwnership($player);
            array_push($playerPipes, $tile);
        }
        return $playerPipes;
    }

    private function generateNewTile() {
        $randNum = rand(self::MIN, self::MAX);
        $rotation = rand(self::MIN, self::MAX) - 1;

        $pieceType = null;
        switch ($randNum) {
            case 1:
                $pieceType = Tile::CAP;
                break;
            case 2:
                $pieceType = Tile::NINETY;
                break;
            case 3:
                $pieceType = Tile::TEE;
                break;
            case 4:
                $pieceType = Tile::STRAIGHT;
                break;
            default:
                // This is the oh crap we messed up case
                $pieceType = Tile::NINETY;
        }

        $pieceRotation = null;
        switch ($rotation) {
            case 0:
                $pieceRotation = Tile::ZERO_ROTATION;
                break;
            case 1:
                $pieceRotation = Tile::NINETY_ROTATION;
                break;
            case 2:
                $pieceRotation = Tile::HALF_ROTATION;
                break;
            case 3:
                $pieceRotation = TILE::TWO_SEVENTY_ROTATION;
                break;
            default:
                // This is the oh crap we messed up case
                $pieceRotation = TILE::ZERO_ROTATION;
        }

        $tile = new Tile($pieceType, $pieceRotation);

        return $tile;
    }

    /**
     * Initialize the board for use. We will set the top pipes on each side of the board to player 1 and the bottom to
     * player 2
     */
    private function initBoard() {
        $this->board = array();

        // We must know the center line to place the start and end pipes
        $centerLine = $this->boardSize / 2;

        for ($i = 0; $i < $this->boardSize; $i++) {
            for($k = 0; $k < $this->boardSize; $k++) {

                // If we are at +/- 3 in the first column we must place the start pipes
                // If we are at +/- 2 in the last column we must place the end pipes
                if ((($centerLine - 3) == $i || ($centerLine + 2) == $i) && $k == 0) {

                    // Set the top pipe owner to player 1
                    if ($centerLine - 3 == $i) {
                        $this->board[$i][$k] = new Tile(TILE::START_PIECE);
                        $this->board[$i][$k]->setOwnership($this->player1);
                    } else {
                        $this->board[$i][$k] = new Tile(TILE::START_PIECE);
                        $this->board[$i][$k]->setOwnership($this->player2);
                    }
                } else if ((($centerLine - 2) == $i || ($centerLine + 1) == $i) && $k == ($this->boardSize -1)) {
                    if ($centerLine - 2 == $i) {
                        $this->board[$i - 1][$k] = new Tile(TILE::END_PIECE_TOP);
                        $this->board[$i - 1][$k]->setOwnership($this->player1);
                        $this->board[$i][$k] = new Tile(TILE::END_PIECE);
                        $this->board[$i][$k]->setOwnership($this->player1);
                    } else {
                        $this->board[$i - 1][$k] = new Tile(TILE::END_PIECE_TOP);
                        $this->board[$i - 1][$k]->setOwnership($this->player2);
                        $this->board[$i][$k] = new Tile(TILE::END_PIECE);
                        $this->board[$i][$k]->setOwnership($this->player2);
                    }
                } else {
                    $this->board[$i][$k] = new Tile();
                }
            }

        }
    }

    public function getBoard() {
        return $this->board;
    }

    /**
     * Return the board size
     */
    public function getBoardSize() {
        return $this->boardSize;
    }

    /**
     * Return whos turn it is
     */
    public function getPlayersTurn() {
        return $this->playersTurn;
    }

    public function getCurrentPlayer() {
        if ($this->playersTurn == $this::PLAYER1) {
            return $this->player1;
        } else {
            return $this->player2;
        }
    }

    /**
     * @param $rowIndex Row to insert into
     * @param $colIndex Col to insert into
     * @param $index Index where the piece is located in the players pipes array
     */
    public function insertAtCell($site, $rowIndex, $colIndex, $index) {
        // Insert the players tile into the game board
        $tile = $this->getCurrentPlayer()->getTileAt($index);
        $this->rotateTileToOpening($rowIndex, $colIndex, $tile);
        $this->board[$rowIndex][$colIndex] = $tile;

        $gameSet = new GameSets($site);
        $gameSet->setPiece($rowIndex, $colIndex,$_SESSION['game'], $tile->getRotation(), $tile->getPieceType(), $tile->getOwnership()->getPlayerNumber());
        // Generate a new tile, set it to the current player, and replace the tile in the players pipe array
        $newTile = $this->generateNewTile();
        $newTile->setOwnership($this->getCurrentPlayer());
        $this->getCurrentPlayer()->replaceTileAt($newTile, $index);

        // It is now the other players turn
        //$this->switchPlayers();

        $games = new Games($site);
        $this->switchPlayers();
        //echo($this->getCurrentPlayer()->getPlayerNumber());
        $games->setTurn($_SESSION['game'], $this->getCurrentPlayer()->getPlayerNumber());
        return $this->getPlayersTurnInt();
    }

    private function rotateTileToOpening($i, $k, $tile) {
        $openingMatched = false;

        // Check which cells have an opening around this cell. $eastOpening means tile to the right has a opening on
        // the west side of the tile
        // Check if the piece above has an opening to the south
        $eastOpening = false;
        $southOpening = false;
        $westOpening = false;
        $northOpening = false;

        if ($i > 0) {
            $northOpening = $this->board[$i - 1][$k]->checkOpening(2);
        }

        // Check if the piece below has an opening to the north
        if ($i < ($this->boardSize - 1)) {
            $southOpening =  $this->board[$i+1][$k]->checkOpening(0);
        }

        // Check if the piece to the left has an opening to the east
        if ($k > 0) {
            $westOpening = $this->board[$i][$k-1]->checkOpening(1);
        }

        // Check if the piece to the right has an opening to the west
        if ($k < ($this->boardSize - 1)) {
            $eastOpening = $this->board[$i][$k+1]->checkOpening(3);
        }

        // Rotate the piece until an opening on the piece matches an opening on a neighbor. We dont care if the piece
        // rotates wierdly, they should have rotated it before we got to this point
        while(!$openingMatched) {
            if (($eastOpening == $tile->checkOpening(1)) && $eastOpening !== false) {
                $openingMatched = true;
            }

            if (($westOpening == $tile->checkOpening(3)) && $westOpening !== false) {
                $openingMatched = true;
            }

            if (($southOpening == $tile->checkOpening(2)) && $southOpening !== false) {
                $openingMatched = true;
            }

            if (($northOpening == $tile->checkOpening(0)) && $northOpening !== false) {
                $openingMatched = true;
            }

            if (!$openingMatched) {
                $tile->rotatePiece();
            }
        }
    }

    private function switchPlayers() {
        if ($this->playersTurn == $this::PLAYER1) {
            $this->playersTurn = $this::PLAYER2;
        } else {
            $this->playersTurn = $this::PLAYER1;
        }
    }

    private function getPlayersTurnInt(){
        if ($this->playersTurn == $this::PLAYER1) {
            return 1;
        } else {
            return 2;
        }
    }

    public function discardPieceAtIndex(Site $site, $index) {
        // Generate a new tile, set it to the current player, and replace the tile in the players pipe array
        $newTile = $this->generateNewTile();
        $newTile->setOwnership($this->getCurrentPlayer());
        $this->getCurrentPlayer()->replaceTileAt($newTile, $index);

        $games = new Games($site);
        $this->switchPlayers();
        //echo($this->getCurrentPlayer()->getPlayerNumber());
        $games->setTurn($_SESSION['game'], $this->getCurrentPlayer()->getPlayerNumber());
        return $this->getPlayersTurnInt();

    }

    public function surrender(Site $site, $id) {

        $games = new Games($site);
        $games->setState($id, 3);
        $this->switchPlayers();
        $games->setTurn($id, $this->getPlayersTurnInt());
        return $this->getPlayersTurnInt();
//        if ($this->playersTurn == $this::PLAYER1) {
//            $this->winner = $this->player2;
//        } else {
//            $this->winner = $this->player1;
//        }
//
//        $this->setGameOver();
    }

    public function checkForWinner($site, $game) {
        $winner = true;

        // Go through all the pieces owned by this player and check to make sure any side with an opening is matched
        // to another piece with an opening
        for ($i = 0; $i < $this->boardSize; $i++) {
            for ($k = 0; $k < $this->boardSize; $k++) {

                // Only check the piece if the player owns it
                if ($this->board[$i][$k]->getOwnership() != null) {
                    if ($this->board[$i][$k]->getOwnership()->getPlayerNumber() == $this->getCurrentPlayer()->getPlayerNumber()) {
                        $tile = $this->board[$i][$k];

                        $eastOpening = false;
                        $southOpening = false;
                        $westOpening = false;
                        $northOpening = false;

                        if ($i > 0) {
                            $northOpening = $this->board[$i - 1][$k]->checkOpening(2);
                        }

                        // Check if the piece below has an opening to the north
                        if ($i < ($this->boardSize - 1)) {
                            $southOpening =  $this->board[$i+1][$k]->checkOpening(0);
                        }

                        // Check if the piece to the left has an opening to the east
                        if ($k > 0) {
                            $westOpening = $this->board[$i][$k-1]->checkOpening(1);
                        }

                        // Check if the piece to the right has an opening to the west
                        if ($k < ($this->boardSize - 1)) {
                            $eastOpening = $this->board[$i][$k+1]->checkOpening(3);
                            // If this is the end piece we want to set the opening to true
                            if ($this->board[$i][$k+1]->getPieceType() == Tile::END_PIECE) {
                                $eastOpening = true;
                            }
                        }


                        // Check against our current tile. If we have an opening on one side and the other side does not
                        // the pipe is not completely closed
                        if ($tile->checkOpening(1) === true && $eastOpening !== true ) {
                            $winner = false;
                        }

                        if ($tile->checkOpening(3) === true && $westOpening !== true) {
                            $winner = false;
                        }

                        if ($tile->checkOpening(2) === true && $southOpening !== true) {
                            $winner = false;
                        }

                        if ($tile->checkOpening(0) === true && $northOpening !== true) {
                            $winner = false;
                        }
                    }
                }
            }
        }


        if ($winner == true) {
            if ($this->playersTurn == $this::PLAYER1) {
                $this->winner = $this->player1;

            } else {
                $this->winner = $this->player2;
            }
        } else {
            if ($this->playersTurn == $this::PLAYER1) {
                $this->winner = $this->player2;
            } else {
                $this->winner = $this->player1;
            }
        }

        //$this->setGameOver();
        $games = new Games($site);
        $games->setState($game, 3);
        $this->switchPlayers();
        $temp = $this->getPlayersTurnInt();

        $games->setTurn($game, $this->winner->getPlayerNumber());

        return $temp;

    }

    public function setGameOver() {
        $this->gameOver = true;
    }

    public function isGameOver() {
        return $this->gameOver;
    }

    public function getWinner() {
        return $this->winner;
    }

    public function isPlaceable($i, $k) {

        // Check if the piece above has an opening to the south
        if ($i > 0) {
            if ($this->board[$i - 1][$k]->getOwnership() != null) {
                if ($this->board[$i - 1][$k]->getOwnership()->getPlayerNumber() == $this->getCurrentPlayer()->getPlayerNumber()) {
                    if ($this->board[$i - 1][$k]->checkOpening(2)) {
                        return true;
                    }
                }
            }
        }

        // Check if the piece below has an opening to the north
        if ($i < ($this->boardSize - 1)) {
            if ($this->board[$i+1][$k]->getOwnership() != null) {
                if ($this->board[$i+1][$k]->getOwnership()->getPlayerNumber() == $this->getCurrentPlayer()->getPlayerNumber()) {
                    $southPlaceable =  $this->board[$i+1][$k]->checkOpening(0);
                    if ($southPlaceable == true) {
                        return true;
                    }
                }
            }
        }

        // Check if the piece to the left has an opening to the east
        if ($k > 0) {
            if ($this->board[$i][$k-1]->getOwnerShip() != null) {
                if ($this->board[$i][$k-1]->getOwnership()->getPlayerNumber() == $this->getCurrentPlayer()->getPlayerNumber()) {
                    if ($this->board[$i][$k-1]->checkOpening(1)) {
                        return true;
                    }
                }
            }
        }

        // Check if the piece to the right has an opening to the west
        if ($k < ($this->boardSize - 1)) {
            if ($this->board[$i][$k+1]->getOwnership() != null) {
                if ($this->board[$i][$k+1]->getOwnership()->getPlayerNumber() == $this->getCurrentPlayer()->getPlayerNumber()) {
                    if ($this->board[$i][$k+1]->checkOpening(3)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function getSteamDirection($i, $k) {

        // Check if the piece to the left has an opening to the east
        if ($k > 0) {
            if($this->board[$i][$k-1]->checkOpening(1)) {
                return 'eastSteam';
            }
        }

        // Check if the piece below has an opening to the north
        if ($i < ($this->boardSize - 1)) {
            if($this->board[$i+1][$k]->checkOpening(0)) {
                return 'northSteam';
            }
        }

        if ($i > 0) {
            if($this->board[$i - 1][$k]->checkOpening(2)) {
                return 'southSteam';
            }
        }

        // Check if the piece to the right has an opening to the west
        if ($k < ($this->boardSize - 1)) {
            if($this->board[$i][$k+1]->checkOpening(3)) {
                return 'westSteam';
            }
        }

        return 'noSteam';
    }

    public function addTiles($tiles){
        //echo("Entered Function");
        foreach($tiles as $tile){
            $tile = new GameSet($tile);
            $insert = new Tile($tile->getType(), $tile->getRotation());
            if($tile->getOwnership() == 1) {
                $insert->setOwnership($this->player1);
            }
            else{
                $insert->setOwnership($this->player2);
            }
            $this->board[$tile->getXLoc()][$tile->getYLoc()] = $insert;
            //echo("HERE");
        }
    }
}