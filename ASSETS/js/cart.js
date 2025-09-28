document.addEventListener('DOMContentLoaded', function() {
    // Function to handle the AJAX request to add item to cart
    function handleAddToCart(productId, quantity) {
        const cartCountElement = document.querySelector('.cart-count');
        
        // Use the Fetch API to send data asynchronously
        fetch('cart_handler.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}&quantity=${quantity}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Success: Update the cart count badge in the header
                if (cartCountElement) {
                    cartCountElement.textContent = data.cart_count;
                }
                
                // Optional: Show a temporary success notification/toast
                console.log(data.message);
                // alert(data.message); 
            } else {
                // Failure: Log the error
                console.error("Failed to add to cart:", data.message);
            }
        })
        .catch(error => {
            console.error('AJAX Error adding to cart:', error);
        });
    }

    // --- 1. Handle Clicks on the Product Listing Page (meat_beef.php) ---
    // Listen for clicks on the parent grid/container
    const productGrid = document.querySelector('.product-grid');
    if (productGrid) {
        productGrid.addEventListener('click', function(e) {
            const addButton = e.target.closest('.add-to-cart-btn');
            
            if (addButton) {
                // Prevent the button click from navigating to the product detail page
                e.preventDefault(); 
                e.stopPropagation();

                // Get the product ID from the parent link's href attribute
                const productLink = addButton.closest('.product-card-link');
                if (productLink) {
                    // Extract ID from the URL: product_detail.php?id=X
                    const urlParams = new URLSearchParams(productLink.href.split('?')[1]);
                    const productId = parseInt(urlParams.get('id'));
                    
                    if (productId) {
                        handleAddToCart(productId, 1); // Always add 1 from the grid view
                    }
                }
            }
        });
    }

    // --- 2. Handle Clicks on the Single Product Detail Page (product_detail.php) ---
    const detailAddButton = document.querySelector('.product-detail-container .add-to-cart-btn');
    const detailQtyDropdown = document.querySelector('.product-detail-container .qty-dropdown');
    
    if (detailAddButton) {
        detailAddButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get the product ID from the current URL
            const urlParams = new URLSearchParams(window.location.search);
            const productId = parseInt(urlParams.get('id'));
            
            // Get the selected quantity, default to 1 if no dropdown or selection
            let quantity = 1;
            if (detailQtyDropdown && detailQtyDropdown.value !== 'Qty') {
                quantity = parseInt(detailQtyDropdown.value);
            }
            
            if (productId && quantity) {
                handleAddToCart(productId, quantity);
            } else {
                console.error("Cannot add to cart: Product ID or Quantity is missing/invalid.");
            }
        });
    }
});

// --- 3. Handle Cart Page Interactions (cart.php) ---
    
    const cartContainer = document.querySelector('.cart-container');
    if (cartContainer) {
        
        // Function to send update/remove request
        function sendCartUpdate(productId, action, quantity = 0) {
            const cartCountElement = document.querySelector('.cart-count');
            
            fetch('update_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `product_id=${productId}&action=${action}&quantity=${quantity}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the header badge
                    if (cartCountElement) {
                        cartCountElement.textContent = data.cart_count;
                    }
                    
                    // Crucial: Reload the page to reflect price changes and removal, 
                    // since PHP calculated the current cart totals.
                    window.location.reload(); 

                } else {
                    console.error("Cart update failed:", data.message);
                }
            })
            .catch(error => {
                console.error('AJAX Error during cart update:', error);
            });
        }
        
        // Listener for Quantity Dropdowns
        cartContainer.addEventListener('change', function(e) {
            const qtySelect = e.target.closest('.item-qty-select');
            if (qtySelect) {
                const productId = qtySelect.dataset.productId;
                const newQuantity = parseInt(qtySelect.value);
                
                if (newQuantity > 0) {
                    sendCartUpdate(productId, 'update', newQuantity);
                } else {
                    // If quantity is somehow set to 0, treat as remove
                    sendCartUpdate(productId, 'remove');
                }
            }
        });
        
        // Listener for Remove Buttons
        cartContainer.addEventListener('click', function(e) {
            const removeBtn = e.target.closest('.remove-btn');
            
            if (removeBtn) {
                e.preventDefault(); // Stop default action (if any)
                const productId = removeBtn.dataset.productId;
                
                if (confirm("Are you sure you want to remove this item?")) {
                    sendCartUpdate(productId, 'remove');
                }
            }
        });
    }