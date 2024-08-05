const lkAvatar = document.querySelector('.lk-box');
const dropdownMenu = document.querySelector('.dropdown-menu');
console.log(lkAvatar);
console.log(dropdownMenu);
lkAvatar.addEventListener('click', () => {
    dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
});

document.addEventListener('click', (event) => {
    if (!lkAvatar.contains(event.target) && !dropdownMenu.contains(event.target)) {
        dropdownMenu.style.display = 'none';
    }
});