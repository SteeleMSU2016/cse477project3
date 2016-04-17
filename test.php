
<form method="post" action="post.php">
<input onclick="confirmDelete(event)" type="submit" value="Delete!">
</form>

function confirmDelete(event) {
    if(!confirm('Are you sure?')) {
        event.preventDefault();
    }
}

<script>
window.onload = function() {
   document.getElementById("form").onsubmit = function(event) {

    var guess = document.getElementById("guess").value;
    var result = document.getElementById("result").value;
    if(guess === null || guess === "") {
        event.preventDefault();
        result.innerHTML =  "Silly you, enter a number!";
    }

  }
}
</script>


function guess() {
    console.log("guess");
    document.getElementById("form").onsubmit = function(event) {
    event.preventDefault();

        var guess = Number(document.getElementById("guess").value);
        var result = document.getElementById("result");
        console.log(guess);

        result.innerHTML =  "Silly you, enter a number!";

        if(guess){
            result.innerHTML =  "";
            return;
        }

    }
}

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<script>
window.onload = guess;
</script></head>
<body>
<form id="form"  method="post">
    <p>Guess: <input type="text" id="guess"></p>
    <p><input type="submit"></p>
    <a href="" id="giveup">I give up!</a>
    <p id="result">&nbsp;</p>
</form>

</div>
</body>

</html>



///////////////////////////////////////////
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Combination Lock</title>
<script>
window.onload = combi;
</script>
<style>
input[type="submit"] {
    width: 5em;
    margin: 0.5em;
}

p {
    text-align: center;
}
</style>
</head>
<body>

<div id="lock"></div>

</body>
</html>
///////////////////////////////

function combi() {
    // The current combination as entered
    var code = "";

    // The secret code we are looking for
    var secret = "CABB";

    /*
     * Create the HTML and put it into the div
     */
    var lock = document.getElementById("lock");

    var html = '<form>' +
        '<p id="code">&nbsp;</p>' +
        '<p>' +
        '<input type="submit" id="A" value="A">' +
        '<input type="submit" id="B" value="B">' +
        '<input type="submit" id="C" value="C">' +
        '<input type="submit" id="D" value="D">' +
        '<input type="submit" id="clear" value="Clear"></p>' +
        '<p id="status">Closed</p></form>';

    lock.innerHTML = html;

    /*
     * Install clear listener
     */
    document.getElementById("clear").onclick = function(event) {
        event.preventDefault();
        code = "";
        update();
    }

    /*
     * Install button listeners
     */
    installListener("A");
    installListener("B");
    installListener("C");
    installListener("D");

    /*
     * Install a button listener. I assume the
     * button id is the letter we are clicking
     */
    function installListener(letter) {
        document.getElementById(letter).onclick = function(event) {
            event.preventDefault();
            code += letter;
            update();
        }
    }

    /*
     * Update the code and status paragraphs to indicate
     * the current word and lock status
     */
    function update() {
        if(code === '') {
            document.getElementById("code").innerHTML = "&nbsp;";
        } else {
            document.getElementById("code").innerHTML = code;
        }

        document.getElementById("status").innerHTML = code === secret ? "Open" : "Closed";
    }
}