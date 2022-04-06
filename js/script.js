
'use strict';

const IP = '192.168.0.101'//'185.35.160.110:8101';
//const OUT_ARR = [1, 2, 3 , 5, 9];

if (window.location.pathname === '/') {
  const container = document.querySelector('.content-control');

  const OUT_ARR = container.dataset.out.split(',').map(item => {
    return item.trim();
  });

  const OUT_NAME = JSON.parse(container.dataset.outName);


  addBtnToContainer(container, OUT_ARR, OUT_NAME);
  isActive(IP, OUT_NAME);

  setInterval(() => {
    isActive(IP, OUT_NAME);
  }, 1000);

  container.addEventListener('click' , event => {
    const out = event.target.dataset.out;

    fetch(`/php/laurent.php?ip=${IP}&out=${out}&st=toggle`)
      .then(res => res.text())
      .then(data => {
        console.log(data);
        isActive(IP, OUT_NAME);
      })
  });
}

if (window.location.pathname === '/route/auth/') {
  const btn = document.querySelector('.auth__btn');

  btn.addEventListener('click', () => {
    window.location.reload();
  });
}

if (window.location.pathname === '/route/admin/') {
  const container = document.querySelector('.admin-access-card-container');

  container.addEventListener('click', event => {
    if (event.target.dataset.btn === 'btn') {
      const card = event.target.closest('.admin-access-card');
      const body = card.querySelector('.admin-access-card__body');

      body.classList.toggle('admin-access-card__body--hidden');
    }
  });
}


function addBtnToContainer(container, outArr, outName) {
  if (outArr.length <= 1) {
    outArr.forEach((item, i) => {
      container.insertAdjacentHTML('beforeend' , `
        <div class="content-control__btn-container">
          <button class="content-control__btn btn-control" data-out="${item}"></button>

          <span class="content-control__text">${outName[item].name}</span>
        </div>
      `);
    });
  } else {
    container.classList.add('content-control--many');

    outArr.forEach((item, i) => {
      container.insertAdjacentHTML('beforeend' , `
        <div class="content-control__btn-container content-control__btn-container--many">
          <button class="content-control__btn btn-control" data-out="${item}"></button>

          <span class="content-control__text">${outName[item].name}</span>
        </div>
      `);
    });
  }
}

function isActive(ip, outName) {
  const allBtn = document.querySelectorAll('.content-control__btn');

  fetch(`/php/laurent.php?ip=${ip}`)
    .then(res => res.json())
    .then(data => {
      const outActive = data.out_table0.split('');

      outActive.forEach((item, i) => {
        allBtn.forEach((btn, j) => {
          if (i === btn.dataset.out - 1) {
            if (item == outName[i + 1].rev ? 0 : 1) {
              btn.classList.add('content-control__btn--active');
              btn.textContent = 'on';
            } else {
              btn.classList.remove('content-control__btn--active');
              btn.textContent = 'off';
            }
          }
        });
      });
    });
}
