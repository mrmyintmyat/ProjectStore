$(document).ready(function() {
    $("#reverseCheck1").change(function() {
        let isChecked = $(this).is(":checked");
        let check_input = $(".form-check-input:not(#reverseCheck1)");

        check_input.each(function() {
            let isCheckboxChecked = $(this).is(":checked");

            if (isChecked && !isCheckboxChecked) {
                $(this).click();
            } else if (!isChecked && isCheckboxChecked) {
                $(this).click();
            }
        });
    });
    let carts = $(".cart");

    carts.each(function() {
        let cart = $(this);
        let countElements = cart.find(".count");
        let count_input = cart.find(".count_input");
        let itemCount = Number(countElements.text());;
        let totalPrice = 0;

        let plus = cart.find(".plus");
        let minus = cart.find(".minus");
        let item_count = cart.find("#item_count");
        let count_total = $(".count_total");
        let priceElements = cart.find(".price");
        let checkboxes = cart.find("input[type='checkbox']");

        let get_price = cart.find(".price");
        let org_price = cart.find("#org_price");
        let price = parseFloat(get_price.text().replace(/\D/g, ''));
        let plus_price = parseFloat(org_price.html().replace(/\D/g, ''));
        let total = $(".total");

        if (itemCount === 1) {
            minus.prop("disabled", true);
            minus.css("cursor", "no-drop");
            minus.css("opacity", "0.3");
        }

        if (itemCount === Number(item_count.html())) {
            plus.prop("disabled", true);
            plus.css("cursor", "no-drop");
            plus.css("opacity", "0.3");
        }

        // Plus button click event
        plus.click(function() {
            if (itemCount === Number(item_count.html())) {
                return;
            }
            minus.prop("disabled", false);
            minus.css("cursor", "pointer");
            minus.css("opacity", "1");
            // Update item count and total price
            totalPrice = price + plus_price;

            // Update UI

            priceElements.text("MMK" + totalPrice.toFixed(0));
            price = totalPrice;
            // total.each(function() {
            //     // let total_price = parseFloat($(this).text().replace(/\D/g,
            //     //     ''));

            //     // if (itemCount === 1) {
            //     //     total_price += plus_price * 2;
            //     // } else {
            //     //     total_price += plus_price;
            //     // }
            // });
            let isChecked = checkboxes.is(":checked");
            if (isChecked) {
                if (total.length > 0) {
                    count_total.each(function() {
                        let total_count = parseFloat($(this).text().replace(/\D/g,
                            ""));
                        total_count += 1;
                        $(this).text(total_count.toFixed(0));
                    });
                    total.each(function() {
                        let total_price = parseFloat($(this).text().replace(
                            /\D/g, ''));
                        total_price = total_price += plus_price;
                        $(this).text("MMK" + total_price.toFixed(0));
                    });
                }
            }

            itemCount++;
            countElements.text(itemCount);
            count_input.val(itemCount);
            if (itemCount === Number(item_count.html())) {
               plus.prop("disabled", true);
               plus.css("cursor", "no-drop");
               plus.css("opacity", "0.3");
            }
        });


        // Minus button click event
        minus.click(function() {
            if (itemCount > 1) {
                // Update item count and total price

                totalPrice = price - plus_price;

                // Update UI
                priceElements.text("MMK" + totalPrice.toFixed(0));
                price = totalPrice

                let isChecked = checkboxes.is(":checked");
                let total = $(".total");
                if (isChecked) {
                    if (total.length > 0) {
                        count_total.each(function() {
                            let total_count = parseFloat($(this).text().replace(/\D/g,
                                ""));
                            total_count -= 1;
                            $(this).text(total_count.toFixed(0));
                        });
                        total.each(function() {
                            let total_price = parseFloat($(this).text().replace(
                                /\D/g, ''));
                            total_price = total_price -= plus_price;
                            $(this).text("MMK" + total_price.toFixed(0));
                        });
                    }
                }

                plus.prop("disabled", false);
                plus.css("cursor", "pointer");
                plus.css("opacity", "1");

                itemCount--;
                countElements.text(itemCount);
                count_input.val(itemCount);
                if (itemCount === 1) {
                    minus.prop("disabled", true);
                    minus.css("cursor", "no-drop");
                    minus.css("opacity", "0.3");
                }

            }
        });
        // Checkbox change event
        checkboxes.change(function() {
            let isChecked = $(this).is(":checked");
            let total = $(".total");
            let undisabled = $(".undisabled");
            if (isChecked) {
                count_total.each(function() {
                    let total_count = parseFloat($(this).text().replace(/\D/g,
                        ""));
                    total_count += itemCount;
                    $(this).text(total_count.toFixed(0));
                });
                if (total.length > 0) {
                    total.each(function() {
                        let total_price = parseFloat($(this).text().replace(/\D/g,
                            ""));
                        total_price += price;
                        $(this).text("MMK" + total_price.toFixed(0));
                        if (total_price !== 0) {
                            undisabled.prop("disabled", false);
                        }
                    });
                }
            } else {
                if (total.length > 0) {
                    count_total.each(function() {
                        let total_count = parseFloat($(this).text().replace(/\D/g,
                            ""));
                        total_count -= itemCount;
                        $(this).text(total_count.toFixed(0));
                    });
                    total.each(function() {
                        let total_price = parseFloat($(this).text().replace(/\D/g,
                            ""));
                        total_price -= price;
                        $(this).text("MMK" + total_price.toFixed(0));
                        if (total_price === 0) {
                            undisabled.prop("disabled", true);
                        }
                    });
                }
            }
        });
    });
});
