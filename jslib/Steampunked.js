function Steampunked(sel) {

    // The form representing the gameboard
    var form = $(sel);

    // Prevent the form from submitting
    form.submit(function(event) {
        event.preventDefault();
    });

    // Install click listeners on all cells
    this.installCellListeners();

    this.parse_json = function (json) {
        try {
            var data = $.parseJSON(json);
        } catch(err) {
            throw "JSON parse error: " + json;
        }

        return data;
    }
}

Steampunked.prototype.installCellListeners = function() {
    var that = this;

    $('.insertAtCell').click(function() {
        $('#errorMessage').html('');
        var insertAtCell = $(this).val();
        var selectedButtonVal = $('input[name=selectedButton]:checked').val();
        if (selectedButtonVal != undefined) {
            $.ajax({
                 url: "steampunked-post.php",
                 data: {
                    insertAtCell: insertAtCell,
                    selectedButton: selectedButtonVal
                 },
                 method: "POST",
                 success: function(data) {
                    var json = that.parse_json(data);
                    if (json.message == 'ok') {
                        $('form').html(json.html);
                    } else {
                        console.log('failed to rotate piece');
                    }
                 },
                 error: function(xhr, status, error) {
                    console.log('failed');
                 }
            });
        } else {
            $('#errorMessage').html('You must select a pipe to place');
        }
    });
}

Steampunked.prototype.installButtonListeners = function() {
    var that = this;

    $('#rotate').click(function() {
        $('#errorMessage').html('');
        var selectedButtonVal = $('input[name=selectedButton]:checked').val();
        $.ajax({
            url: "steampunked-post.php",
            data: {
                rotate: true,
                selectedButton: selectedButtonVal
            },
            method: "POST",
            success: function(data) {
                var json = that.parse_json(data);
                if (json.message == 'ok') {
                    $('#playerPiecesWrapper').html(json.html);
                } else {
                    console.log('failed to rotate piece');
                }
            },
            error: function(xhr, status, error) {
                console.log('failed');
            }
        });
    });

    $('#discard').click(function() {
        $('#errorMessage').html('');
        var selectedButtonVal = $('input[name=selectedButton]:checked').val();
        $.ajax({
            url: "steampunked-post.php",
            data: {
                discard: true,
                selectedButton: selectedButtonVal
            },
            method: "POST",
            success: function(data) {
                var json = that.parse_json(data);
                if (json.message == 'ok') {
                    $('form').html(json.html);
                } else {
                    console.log('failed to discard piece');
                }
            },
            error: function(xhr, status, error) {
                console.log('failed');
            }
        });
    });

    $('#openValve').click(function() {
        $('#errorMessage').html('');
        $.ajax({
            url: "steampunked-post.php",
            data: {
                openValve: true
            },
            method: "POST",
            success: function(data) {
                var json = that.parse_json(data);
                if (json.message == 'ok') {
                    $('form').html(json.html);
                } else {
                    console.log('failed to open valve');
                }
            },
            error: function(xhr, status, error) {
                console.log('failed');
            }
        });
    });

    $('#giveUp').click(function() {
        $('#errorMessage').html('');
        $.ajax({
            url: "steampunked-post.php",
            data: {
                giveUp: true
            },
            method: "POST",
            success: function(data) {
                var json = that.parse_json(data);
                if (json.message == 'ok') {
                    $('form').html(json.html);
                } else {
                    console.log('failed to give up');
                }
            },
            error: function(xhr, status, error) {
                console.log('failed');
            }
        });
    });
}