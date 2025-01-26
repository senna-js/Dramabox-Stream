<?php
ini_set('display_errors', 0);
if (isset($_GET['bookId']) && isset($_GET['bookNameLower'])) {
    $bookId = htmlspecialchars($_GET['bookId']);
    $bookNameLower = htmlspecialchars($_GET['bookNameLower']);
    $apiUrl = 'https://www.dramaboxdb.com/_next/data/dramaboxdb_prod_20250114/in/movie/' . $bookId . '/' . $bookNameLower . '.json';
    $data = file_get_contents($apiUrl);

    if ($data === false) {
        die('Error fetching data');
    }

    $dataArray = json_decode($data, true);

    if (!isset($dataArray['pageProps']['chapterList']) || empty($dataArray['pageProps']['chapterList'])) {
        die('Error: chapterList not found or is empty');
    }

    $chapterList = $dataArray['pageProps']['chapterList'];

    $firstEpisode = $chapterList[0];
    $firstEpisodeCover = $firstEpisode['cover'];
    $firstEpisodeVideoUrl = str_replace('.mp4.jpg@w=100&h=135', '.720p.narrowv3.mp4', $firstEpisodeCover);

    $bookInfo = $dataArray['pageProps']['bookInfo'];
    $bookName = $bookInfo['bookName'];
    $viewCount = $bookInfo['viewCount'];
    $followCount = $bookInfo['followCount'];
    $introduction = $bookInfo['introduction'];
    $chapterCount = $bookInfo['chapterCount'];
} else {
    die('Error: Missing bookId or bookNameLower');
}
?>

<?php include 'components/header.php'; ?>
<main class="flex flex-col md:flex-row justify-center items-start p-4 space-y-4 md:space-y-0 md:space-x-4">
  <section class="w-full md:w-2/3 bg-black rounded-lg overflow-hidden">
    <video id="videoPlayer" class="w-full h-auto object-cover" controls>
      <source id="videoSource" src="<?= htmlspecialchars($firstEpisodeVideoUrl); ?>" type="video/mp4">
      Your browser does not support the video tag.
    </video>
  </section>

  <section class="w-full md:w-2/3 lg:w-64 bg-white p-4 rounded-lg space-y-4">
    <h2 class="text-xl font-semibold">Episode [1/<?= htmlspecialchars($chapterCount); ?>]</h2>
    <div class="max-h-96 overflow-y-auto">
      <div class="grid grid-cols-3 gap-4" id="episodeList">
        <?php
        foreach ($chapterList as $index => $episode) {
          $formattedIndex = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
          $episodeCover = $episode['cover'];
          if ($episodeCover) {
            $videoUrl = str_replace('.mp4.jpg@w=100&h=135', '.720p.narrowv3.mp4', $episodeCover);
            ?>
            <a href="#" class="block px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded text-center episode-button" data-video="<?= htmlspecialchars($videoUrl); ?>">
              <img src="<?= htmlspecialchars($episodeCover); ?>" alt="Episode <?= $formattedIndex; ?> cover" class="w-full h-auto rounded-md mb-2" loading="lazy">
              <?= $formattedIndex; ?>
            </a>
            <?php
          }
        }
        ?>
      </div>
    </div>
  </section>
</main>

<div class="mt-4 bg-white p-4 rounded-lg shadow-md w-full md:w-2/3 mx-auto">
  <table class="table-auto w-full rounded-lg">
    <tbody>
      <tr>
        <td class="font-semibold p-2">Nama</td>
        <td class="p-2"><?= htmlspecialchars($bookName); ?></td>
      </tr>
      <tr>
        <td class="font-semibold p-2">Statistik</td>
        <td class="p-2"><?= htmlspecialchars($viewCount); ?> Watched | <?= htmlspecialchars($followCount); ?> Follower</td>
      </tr>
      <tr>
        <td class="font-semibold p-2">Synopsis:</td>
        <td class="p-2"><?= nl2br(htmlspecialchars($introduction)); ?></td>
      </tr>
    </tbody>
  </table>
</div>

<?php include 'components/footer.php'; ?>