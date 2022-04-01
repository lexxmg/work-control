
'use strict';

const IP = '192.168.0.101'//'185.35.160.110:8101';
const OUT = 4;

if (window.location.pathname === '/') {
  const btn = document.querySelector('.content-control__btn');

  setInterval(() => {
    isActiveOut(IP, OUT, btn);
  }, 1000);

  btn.addEventListener('click', () => {
    fetch(`/php/laurent.php?ip=${IP}&out=${OUT}&st=toggle`)
      .then(res => res.text())
      .then(data => {
        console.log(data);
        isActiveOut(IP, OUT, btn);
      })
  });
}

if (window.location.pathname === '/route/auth/') {
  const btn = document.querySelector('.auth__btn');

  btn.addEventListener('click', () => {
    window.location.reload();
  });
}

function isActiveOut(ip, out, element) {
  fetch(`/php/laurent.php?ip=${ip}`)
    .then(res => res.json())
    .then(data => {
      if ( +data.out_table0.split('')[out - 1] ) {
        element.classList.add('content-control__btn--active');
      } else {
        element.classList.remove('content-control__btn--active');
      }
    });
}
