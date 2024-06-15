<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>閱緣書坊</title>
    <?php include '.Style.php'; ?>
</head>
<!-- 主題切換 -->
<?php include '.Theme.php'; ?>

<body class=<?php echo htmlspecialchars($theme); ?>>
    <!-- 標題橫條 + 切換按鈕 -->
    <?php include '.Header.php'; ?>
    <!-- 搜尋資料, 需要放在.Header後面, 因為它有購物車 -->
    <?php include '.ProductFilter.php'; ?>
    <!-- 主要頁面內容開始 -->
    <main id="main-content">
        <section>
            <!-- 廣告輪播區域開始 -->
            <section class="container">
                <div class="slider-wrapper mt-10vh">
                    <!-- 廣告圖片開始 -->
                    <div class="slider">
                        <img id="slide-1" src="images/137_113459734_67_mainCoverImage1.jpg" alt="slider 1">
                        <img id="slide-2" src="images/134_103429221_291_mainCoverImage1.jpg" alt="slider 2">
                        <img id="slide-3" src="images/131_181345651_116_mainCoverImage1.jpg" alt="slider 3">
                    </div>
                    <!-- 廣告圖片結束 -->
                    <!-- 廣告輪播按鈕開始 (下方的三個點) -->
                    <div class="slider-nav">
                        <a data-index="0"></a>
                        <a data-index="1"></a>
                        <a data-index="2"></a>
                    </div>
                    <!-- 廣告輪播按鈕結束 -->
                    <!-- 上一頁箭頭按鈕 -->
                    <a class="prev-arrow fs-2"><i class='bx bx-chevron-left'></i></a>
                    <!-- 下一頁箭頭按鈕 -->
                    <div class="next-arrow fs-2"><i class='bx bx-chevron-right'></i></div>
                </div>
            </section>
            <!-- 廣告輪播區域結束 -->
            <!-- 商品購買區域開始 -->
            <section class="container mt-5">
                <!--分類按鈕開始 -->
                <form action="" method="get">
                    <div class="row mb-4">
                        <div class="col-md-6 d-flex">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo htmlspecialchars($current_category_name); ?>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <?php foreach ($categories as $category): ?>
                                        <li><a class="dropdown-item"
                                                href="?category=<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <!-- 升或降序 -->
                            <div class="mt-2 ms-2">
                                <input class="form-check-input" type="checkbox" id="orderCheckbox" name="order"
                                    value="asc" <?php echo isset($_GET['order']) && $_GET['order'] == 'asc' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="orderCheckbox">最舊</label>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <div id='search-box' class="input-group">
                                <input type="search" name="search" class="form-control" placeholder="搜尋商品..."
                                    value="<?php echo htmlspecialchars($search); ?>">
                                <input type="hidden" name="category" value="<?php echo $current_category_id; ?>">
                                <button type="submit" class="btn btn-primary bx bx-search"></button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- 購物列表 -->
                <div class="row" id="shopping-list"></div>
                <div id="no-products-message">沒有找到商品資料</div>
                <!-- 分頁按鈕 -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end me-2">
                        <!-- 分頁按鈕用 JavaScript 動態生成 -->
                    </ul>
                </nav>
            </section>
            <!-- 商品購買區域結束 -->
        </section>
    </main>
    <?php include '.Footer.php'; ?>
</body>
<?php include '.Script.php'; ?>
<script src="js/.Index.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const itemsPerPage = 18; //一頁 18 個商品
        const allProducts = <?php echo json_encode($products); ?>;
        let currentPage = 1;

        // 為了動態更新頁面, 使用 javascript 
        function renderProducts(products) {
            const shoppingList = document.getElementById('shopping-list');
            shoppingList.innerHTML = '';
            products.forEach(product => {
                const productHtml = `
                    <div class='col-md-2 product-item'ad title='${(product.name)}'>
                        <a href='product.php?id=${product.id}' class='card-link text-decoration-none text-primary'>
                            <div class='card mb-3 d-flex flex-column'>
                                <img src='${product.image}' class='card-img-top' alt='Product Image'>
                                <div class='card-body d-flex flex-column'>
                                    <h5 class='card-title text-Nmain clamp-lines mb-auto'>${product.name}</h5>
                                    <a class='cart-link' href="#" data-product-id="${product.id}" data-product-name="${product.name}" data-product-price="${product.price}">
                                        <button class='btn cart' aria-label='購物車圖示'><i class='bi bi-cart'></i></button>
                                    </a>
                                    <p class='card-text fw-bold text-orange mt-auto'>$${product.price}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                `;
                shoppingList.insertAdjacentHTML('beforeend', productHtml);

            });
            bindCartButton();
        }

        function showPage(page) {
            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const productsToShow = allProducts.slice(start, end);
            renderProducts(productsToShow);

            // 檢查是否有產品顯示
            const noProductsMessage = document.getElementById('no-products-message');
            if (productsToShow.length === 0) {
                noProductsMessage.style.display = 'block';
            } else {
                noProductsMessage.style.display = 'none';
            }
        }

        function createPagination(totalPages, currentPage) {
            const paginationList = document.querySelector('.pagination');
            paginationList.innerHTML = '';

            if (totalPages <= 1) return;

            const createPageItem = (page) => {
                const li = document.createElement('li');
                li.classList.add('page-item');
                if (page === currentPage) li.classList.add('active');
                const a = document.createElement('a');
                a.classList.add('page-link');
                a.href = '#';
                a.textContent = page;
                a.addEventListener('click', (e) => {
                    e.preventDefault();
                    currentPage = page;
                    showPage(currentPage);
                    createPagination(totalPages, currentPage);
                });
                li.appendChild(a);
                return li;
            };

            const createEllipsis = () => {
                const li = document.createElement('li');
                li.classList.add('page-item');
                const span = document.createElement('span');
                span.classList.add('page-link');
                span.textContent = '...';
                li.appendChild(span);
                return li;
            };

            // 第一頁顯示
            paginationList.appendChild(createPageItem(1));

            if (currentPage > 3) {
                paginationList.appendChild(createEllipsis());
            }

            for (let i = Math.max(2, currentPage - 1); i <= Math.min(totalPages - 1, currentPage + 1); i++) {
                paginationList.appendChild(createPageItem(i));
            }

            if (currentPage < totalPages - 2) {
                paginationList.appendChild(createEllipsis());
            }

            // 最後一頁顯示
            if (totalPages > 1) {
                paginationList.appendChild(createPageItem(totalPages));
            }
        }

        const totalPages = Math.ceil(allProducts.length / itemsPerPage);
        showPage(currentPage);
        createPagination(totalPages, currentPage);

        // 檢查是否有產品顯示
        const noProductsMessage = document.getElementById('no-products-message');
        if (allProducts.length === 0) {
            noProductsMessage.style.display = 'block';
        } else {
            noProductsMessage.style.display = 'none';
        }

        // 完成後顯示內容
        document.getElementById('main-content').style.display = 'block';
    });
</script>


</html>