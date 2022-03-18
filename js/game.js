var player;
const playerStateIcons = {
    play: "bi bi-play-circle",
    pause: "bi bi-pause-circle",
    next: "bi bi-skip-forward-circle",
    stop: "bi bi-stop-circle",
    replay: "bi bi-arrow-clockwise",
    hidden: "hidden"
}
var results = [];
var playerIconState = null;
var level = 0;
var currentSong = null;
var currentSongNumber = null;
var answerHtml = `
<div class="py-2 rounded-circle">
    <p data-answer-id="{{id}}" class="answear">{{answer}}</p>
</div>
`


$(document).ready(function () {
    $('#play').click(function () {
        currentSongNumber = Object.keys(songs)[level];
        currentSong = songs[currentSongNumber];
        level++;
        $(this).hide()
        drawAnswers()
        initPlayer()
    })

    $("body").on("click tap", ".answear", function () {
        var currentAnswer = $(this)
        var answerId = currentAnswer.data("answer-id");


        $.ajax({
            type: "POST",
            url: "../check_answer.php",
            data: {
                'answer_id': answerId,
                'song_id': currentSong.id
            },
            success: function (response) {
                if(results[currentSongNumber] === undefined) {
                    results[currentSongNumber] = response
                    $(".answear").removeClass("error")
                    $(".answear").removeClass("success")
                    if(response) {
                        currentAnswer.removeClass("error")
                        currentAnswer.addClass("success")
                    } else {
                        currentAnswer.removeClass("success")
                        currentAnswer.addClass("error")
                    }
                }

            },
            error: function () {
                alert('error');
            },
            dataType: 'JSON'
        });
        var nextSongNumber = Object.keys(songs)[level + 1];
        if(songs[nextSongNumber] !== undefined) {
            updatePlayerIcon(playerStateIcons.next)
        }
    })

});

// keep
function drawAnswers() {
    var answersWrapper = $('#answers-wrapper');
    answersWrapper.html("");
    var answerItemHtml;
    currentSong.answers.forEach(answerItem => {
        answerItemHtml = $(answerHtml
            .replace("{{answer}}", answerItem.answer)
            .replace("{{id}}", answerItem.id)
        )
        answersWrapper.append(answerItemHtml)
    })
}

// keep
function initPlayer() {

    if (player) {
        return
    }
    player = new YT.Player('player', {
        height: '0',
        width: '0',
        videoId: currentSong.video_id,
        playerVars: {
            start: currentSong.start,
            end: currentSong.end
        },
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });

}

// keep
function onPlayerReady(event) {
    event.target.playVideo();
    updatePlayerIcon(playerStateIcons.pause)
}

// keep
function onPlayerStateChange() {
    console.log('on-player-state');
}

function updatePlayerIcon(icon) {
    playerIconState = icon;
    $("#player-icon").removeClass();
    $("#player-icon").addClass(icon)
}