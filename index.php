<?php
ini_set('display_errors', 0);
$apiUrl = 'https://www.dramaboxdb.com/_next/data/dramaboxdb_prod_20250114/in.json'; 
$data = file_get_contents($apiUrl);

$bigList = [];
$smallData = [];
if ($data !== false) {
    $dataArray = json_decode($data, true);
    $bigList = $dataArray['pageProps']['bigList'] ?? [];
    $smallData = $dataArray['pageProps']['smallData'] ?? [];
}

$translations = [
    '精彩剧集' => 'Drama Menarik',
    '当前热播' => 'Drama Terpopuler Saat Ini',
    '必看好剧' => 'Drama Wajib Tonton',
];
?>

<?php include 'components/header.php'; ?>
<main class="flex flex-col items-center p-4 space-y-4">
    <?php if (count($smallData) > 0): ?>
        <?php foreach ($smallData as $category): ?>
            <section class="w-full md:w-2/3 bg-white p-4 rounded-lg mb-8">
                <h3 class="text-2xl font-semibold mb-4">
                    <?php 
                    echo htmlspecialchars($translations[$category['name']] ?? $category['name']);
                    ?>
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach ($category['items'] as $book): ?>
                        <div class="bg-gray-100 p-3 rounded-md shadow-md relative">
                            <div class="relative">
                                <img src="<?= htmlspecialchars($book['cover']); ?>" alt="<?= htmlspecialchars($book['bookName']); ?>" class="w-full h-auto rounded-md mb-2" loading="lazy">
                                <a href="watchDrama.php?bookId=<?= urlencode($book['bookId']); ?>&bookNameLower=<?= urlencode($book['bookNameLower']); ?>" class="absolute bottom-2 left-1/2 transform -translate-x-1/2 bg-blue-500 text-white px-4 py-1 rounded-lg text-center hover:bg-blue-600 transition">
                                    Tonton
                                </a>
                            </div>
                            <div class="mt-2">
                                <h4 class="text-lg font-semibold"><?= htmlspecialchars($book['bookName']); ?></h4>
                            </div>
                            <div class="mt-2 text-xs text-gray-500">
                                <p>Views: <?= htmlspecialchars($book['viewCountDisplay']); ?> | Eps: <?= htmlspecialchars($book['chapterCount']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>
    <?php endif; ?>

</main>

<?php include 'components/footer.php'; ?>
