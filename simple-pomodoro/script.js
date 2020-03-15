(function(){

const start = document.getElementById('start');
const pause = document.getElementById('pause');
const stop = document.getElementById('stop');
let timer = document.getElementById('timer');
const audio = document.getElementById('audio');
const time = 25 + ":" + "0"+0; 
const title = document.title;
let pointsContainer = document.getElementById('points');
let points = 0;
let isNull = false;
timer.innerHTML = time;

   start.addEventListener('click',function(e){
    this.disabled = true;
     audio.innerHTML = "集中…";
     if(isNull){
        startTimer();
        timer.innerHTML = time;
        isNull = false;
     }else{
        startTimer();
     }
  })

  pause.addEventListener('click', function(){
    if(start.disabled){
      audio.innerHTML = "ひとやすみ";
    }
    start.disabled = false;
    myStopFunction();
  });
  
  stop.addEventListener('click', function(){
    audio.innerHTML = "";
    timer.innerHTML = time;
    myStopFunction();
    start.disabled = false;
    document.title = title;
  });
  
  
let timerName;
function startTimer() {
  let presentTime = timer.innerHTML;
  let timeArray = presentTime.split(/[:]+/);
  let m = checkMinute(timeArray[0] - 0);
  let s = checkSecond((timeArray[1] - 1));

  if(s==59){
    m=m-1;
    if(m<10){
      m="0"+m;
    }
  }
  
  timer.innerHTML = m + ":" + s;
  document.title = timer.innerText;
  timerName = setTimeout(startTimer, 1000);

  if(m==0 && s==0){
    myStopFunction();
    start.disabled = false;
    isNull = true;
    points += 25;
    audio.innerHTML = `<iframe width="400" height="300" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/240233494&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"></iframe>
  `;
    pointsContainer.innerHTML = "FlowPoints: " + points;
  }
}

function myStopFunction() {
    clearTimeout(timerName);
}

function checkMinute(min){
  if(min<=9){
    min = "0" + min;
  }
  return min;
}

function checkSecond(sec) {
  if (sec < 10 && sec >= 0) {sec = "0" + sec}; 
  if (sec < 0) {sec = "59"};
  return sec;
}

})();