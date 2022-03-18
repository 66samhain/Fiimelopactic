var player;
const playerStateIcons = {
    play: "bi bi-play-circle",
    pause: "bi bi-pause-circle",
    next: "bi bi-skip-forward-circle",
    stop: "bi bi-stop-circle",
    replay: "bi bi-arrow-clockwise",
    hidden: "hidden"
}
var playerIconState = null;
var level = 0;
var currentSong = null;
var answerHtml = `
<div class="py-2 rounded-circle">
    <p data-id="{{id}}" class="answer">{{answer}}</p>
</div>
`


$(document).ready(function () {
    $('#play').click(function () {
        currentSong = songs[Object.keys(songs)[level]];
        level++;
        $(this).hide()
        drawAnswers()
        initPlayer()
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


function onPlayerReady(event) {
    event.target.playVideo();
    updatePlayerIcon(playerStateIcons.pause)
}

function onPlayerStateChange() {
    console.log('on-player-state');
}

function updatePlayerIcon(icon) {
    playerIconState = icon;
    $("#player-icon").removeClass();
    $("#player-icon").addClass(icon)
}