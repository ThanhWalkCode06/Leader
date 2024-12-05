function validateSearch() {
    var searchInput = document.getElementById('search').value.trim();
    if (searchInput === '') {
        // alert('Vui lòng nhập từ khóa để tìm kiếm!');
        return false; // Ngăn form gửi đi
    }
    return true;
}
// console.log('hi')
