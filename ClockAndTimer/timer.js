var timer = [0,0,0];

function updateTimer(){

    let h = '0' + timer[0];
    let m = '0' + timer[1];
    let s = '0' + timer[2];

    h = h.substring(h.length - 2, h.length);
    m = m.substring(m.length - 2, m.length);
    s = s.substring(s.length - 2, s.length);

    document.getElementById('h').innerHTML = h;
    document.getElementById('m').innerHTML = m;
    document.getElementById('s').innerHTML = s;

}

function setTimer(mod, pos) {

    if (timer[pos] + mod < 0) {
        timer[pos] = 59;
        if (pos > 0) {
            timer[pos - 1] -= 1;
        }
    } else if (timer[pos] + mod > 59) {
        timer[pos] = 0;
        timer[pos - 1] += 1;
    } else {
        timer[pos] += mod;
    }
    
    updateTimer();

}

updateTimer();