function load_books(category_id) {
    $.ajax({
        url: "http://localhost/book/server/load_books.php?category_id=" + category_id,
        type: "GET",
        success: function (data) {
            $(".book-list").html(data);
        },
    });
}

function view_details(id) {
    $("#viewBookDetailsModal").modal("show");

    // Retrieve book details from the clicked card
    let bookImage = $("#bookImage-" + id).attr("src");
    let bookTitle = $("#bookTitle-" + id).text();
    let bookCategory = $("#bookCategory-" + id).text();
    let bookAuthor = $("#bookAuthor-" + id).text();

    // Populate the view modal with the retrieved details
    $("#viewBookImage").attr("src", bookImage);
    $(".viewBookTitle").text(bookTitle);
    $(".viewBookCategory").text(bookCategory);
    $(".viewBookAuthor").text("Author(s): " + bookAuthor);
}

function update_book(id) {
    $("#updateBookModal").modal("show");

    // Retrieve book details from the clicked card
    let updateBookID = $("#bookID-" + id).text();
    let updateBookImage = $("#bookImage-" + id).attr("src");
    let updateBookTitle = $("#bookTitle-" + id).text();
    let updateBookCategory = $("#bookCategory-" + id).data("category");
    let updateBookAuthor = $("#bookAuthor-" + id).text();

    // Populate the view modal with the retrieved details
    $("#updateBookID").val(updateBookID);
    $("#updateBookImage").attr("src", updateBookImage);
    $("#updateBookTitle").val(updateBookTitle);
    $("#updateBookCategory").val(updateBookCategory);
    $("#updateBookAuthor").val(updateBookAuthor);
}

function delete_book(id) {
    if (confirm("Do you confirm to delete this book?")) {
        window.location = "http://localhost/book/server/delete_book.php?delete=" + id
    }
}

window.onload = function () {
    // Load books on page load
    load_books(0);

    // Function to filter books based on search query
    $("#searchInput").on("keyup", function () {
        var searchQuery = $(this).val().toLowerCase();

        $(".card-list").each(function () {
            var bookTitle = $(this).find(".card-title").text().toLowerCase();
            var bookAuthor = $(this).find(".card-subtitle").text().toLowerCase();
            if (bookTitle.includes(searchQuery) || bookAuthor.includes(searchQuery)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
}