function updateReloj(){
    let f = new Date();
    let h = '0' + f.getHours();
    let m = '0' + f.getMinutes();
    let s = '0' + f.getSeconds();
    let ampm = h >= 12 ? 'PM' : 'AM';

    h = h.substring(h.length - 2, h.length);
    m = m.substring(m.length - 2, m.length);
    s = s.substring(s.length - 2, s.length);

    let reloj = document.getElementById('reloj');

    reloj.innerHTML = `${h}:${m}:${s} ${ampm}`;

    setTimeout(() => {
        updateReloj();
    }, 1000);
}

updateReloj();