document.addEventListener('DOMContentLoaded', () => {
    const menuButton = document.querySelector('.btn-toggle-menu');
    const sidebar = document.getElementById('sidebar-wrapper');

    // Thêm sự kiện click cho nút menu
    menuButton.addEventListener('click', () => {
        sidebar.classList.toggle('active'); // Thay đổi lớp để mở/đóng menu
    });
});

