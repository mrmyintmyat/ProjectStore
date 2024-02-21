$(document).ready(function() {
    //search
    var check_get = false;

    $('#searchForm').submit(function(e) {
        e.preventDefault();
    })
    $('#search').keyup(function(e) {
        var query = $(this).val();
        var inputLength = query.length;
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        if (inputLength != 0) {
            $.ajax({
                type: 'POST',
                url: '/search',
                data: {
                    _token: csrfToken,
                    query: query
                },
                beforeSend: function() {
                    $('#item_container_search').empty();
                    $('#item_container_search').show();
                    $('#item_container').hide();
                    $('.error-message').hide();
                    $('.auto-load').show();
                },
                success: function(data) {
                    if (data.html.length > 0) {
                        $('.auto-load').hide();
                        $('.error-message').hide();
                        var searchResultsDiv = $('#item_container_search');
                        searchResultsDiv.empty();
                        searchResultsDiv.append(data.html);
                    } else {
                        // No more items available
                        $('.error-message').html(
                            `<div class=" text-info"><i class="fa-solid fa-magnifying-glass fa-spin fa-spin-reverse me-2"></i>No more items found</div> `
                            );
                        $('.error-message').show();
                        $('.auto-load').hide();
                    }

                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }else{
            $('#item_container_search').hide();
            $('.error-message').hide();
            $('#item_container').show();
        }

    });
    //scroll get item
    var route = "/";
    var nextPage = 2; // Current page
    var isLoading = false; // Track whether data is being loaded

    // Function to load more items
    function loadMoreItems() {
        if (isLoading) {
            return;
        }

        isLoading = true;
        // $('#loadingIndicator').show();

        $.ajax({
            type: 'GET',
            url: route,
            data: {
                page: nextPage
            },
            beforeSend: function() {
                $('.auto-load').show();
                // $(".main").scrollTop($(".main")[0].scrollHeight);
                // $(window).scrollTop($(document).height()); // Scroll to the bottom of the page

            },
            success: function(response) {
                if (response.length > 0) {
                  setTimeout(() => {
                    $('.auto-load').hide();
                    $('#item_container').append(response);
                    nextPage++;
                    isLoading = false;
                  }, 1500);
                } else {
                    // No more items available
                    setTimeout(() => {
                    $('.error-message').html(
                        `<div class=" text-info"><i class="fa-solid fa-magnifying-glass mb-2 me-2"></i>No more items</div> `
                        );
                    $('.error-message').show();
                    $('.auto-load').hide();
                    check_get = true; // Scroll to the bottom of the page
                }, 1500);
                }
            },
            error: function(xhr, status, error) {
                // console.log(error);
                isLoading = false;
                $('.auto-load').hide();
            }
        });
    }

    // Detect scroll event
    $(".main").scroll(function() {
        var mainElement = $(this);
        var scrollTop = mainElement.scrollTop();
        var scrollHeight = mainElement.prop("scrollHeight");
        var clientHeight = mainElement.height();
        // console.log(scrollTop + clientHeight + 50)
        // console.log(scrollHeight)


        // Internet connection available, proceed with loading more items
        if (scrollTop + clientHeight + 49 >= scrollHeight) {
            if (navigator.onLine) {
                loadMoreItems();
            } else {
                // No internet connection, display error message
                // Show error message to the user
                $(".error-message").html(`<div class=" text-danger">
<i class="fa-solid fa-triangle-exclamation fa-fade"></i>Connection Error
</div> `);
                $(".error-message").show();
                // $(".main").scrollTop($(".main")[0].scrollHeight);
                // $(window).scrollTop($(document).height()); // Scroll to the bottom of the page

            }
        }
        // loadMoreItems();

    });


    // Initial load of items

});
