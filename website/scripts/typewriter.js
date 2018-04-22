var i = 0;
var txt = "Thanks for taking the time out of your busy day to check this out. If you don't mind please give me a little feedback. I'll even make sure you get to listen to some interesting music.";
var speed = 50;

function typeWriter() {
  if (i < txt.length) {
    document.getElementById("demo").innerHTML += txt.charAt(i);
    i++;
    setTimeout(typeWriter, speed);
  }
}
