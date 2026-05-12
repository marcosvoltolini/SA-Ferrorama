const hb = document.getElementById ('hb');
const nav2 = document.getElementById ('nav2');
hb.addEventListener('click', () => {
    hb.classList.toggle('open');
    nav2.classList.toggle('open');
});