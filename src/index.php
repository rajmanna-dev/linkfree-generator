<?php
$themes_source = "https://cdn.jsdelivr.net/npm/linkfree-themes@1.1.0";
$ionicons_source = "https://cdn.jsdelivr.net/npm/ionicons@7.4.0";

$sites = [
  [
    "name" => "LinkedIn",
    "icon" => "logo-linkedin",
    "placeholder" => "https://linkedin.com/in/...",
  ],
  [
    "name" => "Instagram",
    "icon" => "logo-instagram",
    "placeholder" => "https://instagram.com/...",
  ],
  [
    "name" => "Twitch",
    "icon" => "logo-twitch",
    "placeholder" => "https://twitch.tv/...",
  ],
  [
    "name" => "YouTube",
    "icon" => "logo-youtube",
    "placeholder" => "https://youtube.com/c/...",
  ],
  [
    "name" => "X (Twitter)",
    "icon" => "logo-x",
    "placeholder" => "https://x.com/...",
  ],
];

$num_clinks = 3;

# Retreive the list of themes and read the json file
$themes_json = file_get_contents("{$themes_source}/index.json");
$themes = json_decode($themes_json, true);

$lastsite_index = count($sites) - 1;
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="description" content="Create your own LinkFree and have all your links in one place">
  <meta name="author" content="Chris K. Thomas">
  <meta name="keywords" content="linkfree, linktree, link in bio, link in bio alternative, linkfree generator, linktree generator, link in bio generator">
  <meta property="og:title" content="LinkFree Generator">
  <meta property="og:description" content="Create your own LinkFree and have all your links in one place">
  <meta property="og:url" content="https://linkfree.ckt.im/">
  <meta property="og:image" content='https://opengraph.githubassets.com/<?= hash("sha256", date("Y-m-d H:i:s T")) ?>/chriskthomas/linkfree-generator'>
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="LinkFree Generator">
  <meta property="og:locale" content="en_US">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="LinkFree Generator">
  <meta name="twitter:description" content="Create your own LinkFree and have all your links in one place">
  <meta name="twitter:image" content='https://opengraph.githubassets.com/<?= hash("sha256", date("Y-m-d H:i:s T")) ?>/chriskthomas/linkfree-generator'>

  <link rel="stylesheet" href="./css/output.css">
  <title>LinkFree Generator</title>
</head>

<body>
  <main class="grid grid-cols-6">
    <div class="form-container col-span-4 p-8">
      <div class="form-container-header">
        <h1 class="text-2xl font-semibold">Create your own LinkFree!</h1>
        <p class="text-sm my-3">
          Fill out this form to generate your own single page website. All fields are optional except for your name.
          So, don't worry if you don't have all these accounts. The output will be a single <code class="text-red-400">index.html</code>
          file that you can upload to any static hosting provider such as GitHub Pages, Cloudflare Pages, Vercel,
          Netlify, or DigitalOcean Apps.
        </p>
        <form id="form" class="form" action="api.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
          <h2 class="font-semibold text-lg">Personal details</h2>
          <div class="nameFields my-3 bg-teal-50 flex flex-col py-4 px-6 rounded">
            <label for="name" class="form-label font-semibold mb-2">Your Name <span class="text-red-400">*</span></label>
            <input type="text" id="name" name="name" class="form-control outline-none h-10 px-3 rounded" placeholder="e.g., Chris K. Thomas" required>
        
            <label for="url" class="form-label font-semibold mt-3 mb-2">Profile Link</label>
            <input type="url" id="url" name="url" class="form-control outline-none h-10 px-3 rounded" placeholder="e.g., https://chriskthomas.com">
      
            <label for="description" class="form-label font-semibold mt-3 mb-2">Meta Description</label>
            <input type="text" id="description" name="description" class="form-control outline-none h-10 px-3 rounded" placeholder="e.g., Author, Teacher, Student at college">
       
            <input type="file" id="photo" name="photo" class="form-control hidden">
            <label for="photo" class="form-label font-semibold mt-5 py-3 px-5 bg-green-400 text-white w-fit rounded hover:bg-green-500 hover:cursor-pointer">Upload Photo</label>
            <div class="form-text text-sm text-gray-400 my-2"><span class="text-red-400">*</span> Make it small and square (about 220x220px). It will be embedded into the page
              (optional, max 2mb).</div>
          </div>

          <h2 class="font-semibold text-lg mt-4">Social Media links</h2>
          <div class="socialFields my-3 bg-teal-50 flex flex-col p-6 rounded">
            <label for="email" class="form-label font-semibold my-2">Email</label>
            <input type="email" id="email" name="email" class="form-control form-control outline-none h-10 px-3 rounded" placeholder="e.g., linkfree@ckt.im">
              <?php foreach ($sites as $key => $site) { ?>
                <label for="links[<?= $key ?>][url]" class="form-label font-semibold my-2"><?= $site["name"] ?></label>
                <input type="hidden" id="links[<?= $key ?>][name]" name="links[<?= $key ?>][name]" class="form-control outline-none h-10 px-3 rounded" value="<?= $site["name"] ?>">
                <input type="hidden" id="links[<?= $key ?>][icon]" name="links[<?= $key ?>][icon]" class="form-control outline-none h-10 px-3 rounded" value="<?= $site["icon"] ?>">
                <input type="url" id="links[<?= $key ?>][url]" name="links[<?= $key ?>][url]" class="form-control outline-none h-10 px-3 rounded" class="form-control" placeholder="e.g., <?= $site["placeholder"] ?>">
              <?php } ?>
            </div>

          <h2 class="font-semibold text-lg my-4">Add Custom links</h2>
          <?php for ($i = 1; $i <= $num_clinks; $i++) {
            $key = $lastsite_index + $i; ?>
            <div class="customFields my-1.5 bg-teal-50 p-6 rounded">
              <label class="form-label font-semibold">Custom Link <?= $i ?></label>
              <div class="mt-2">
                <div class="input-group flex gap-1 h-10">
                  <input type="text" id="links[<?= $key ?>][name]" name="links[<?= $key ?>][name]" class="form-control px-3 outline-none rounded" placeholder="Name" aria-label="Name">
                  <input type="text" id="links[<?= $key ?>][icon]" name="links[<?= $key ?>][icon]" class="form-control px-3 outline-none rounded" placeholder="Icon" aria-label="Icon">
             
                  <input type="url" id="links[<?= $key ?>][url]" name="links[<?= $key ?>][url]" class="form-control w-full px-3 outline-none rounded" placeholder="Link" aria-label="Link">
                </div>
              </div>
            </div>
          <?php } ?>
          <div class="my-3">
            <?php if ($num_clinks < 50) { ?>
              <a id="additionalLink" class="btn w-fit flex items-center bg-blue-400 text-white font-semibold text-lg rounded-lg py-3 px-4 hover:bg-blue-500" data-index="<?= ($lastsite_index + $num_clinks) ?>" role="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-plus mr-1"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
                Add More Links
              </a>
            <?php } ?>
          </div>
          <div class="template-selector my-2 flex flex-col bg-teal-50 p-6 rounded">
            <label for="theme" class="form-label font-semibold mb-2">Select Template</label>
            <select id="theme" name="theme" class="form-select h-10 px-3 outline-none">
              <option value="" selected>Default</option>
              <?php foreach ($themes as $key => $theme) { ?>
                <option value="<?= htmlspecialchars(json_encode($theme)) ?>"><?= $theme['name'] ?></option>
              <?php } ?>
            </select>
            <input type="hidden" id="themes-source" name="themes-source" value="<?= $themes_source ?>">
            <input type="hidden" id="ionicons-source" name="ionicons-source" value="<?= $ionicons_source ?>">
          </div>
          <div class="form-check my-3 w-full flex justify-between">
            <a id="clear" class="btn bg-blue-400 py-3 px-5 rounded-lg text-white font-semibold hover:bg-blue-500" role="button">Clear</a>
            <button type="checkbox" id="getzip" name="getzip" class="form-check-input bg-red-400 font-semibold text-white rounded-lg p-3 hover:bg-red-500">Download ZIP</button>
          </div>
        </form>
      </div>
    </div>
    <div class="preview-tab">
      <button id="previewButton" class="btn btn-info btn-lg position-fixed bottom-0 end-0 d-flex align-items-center gap-1 z-2 m-3">Preview</button>
      <div id="previewBlock" class="offcanvas offcanvas-end z-1"></div>
    </div>
  </main>

  <footer class="bg-black h-40 text-white">
    <div class="footer-container flex justify-between items-center h-full px-6">
      <div class="sponsor">
        <p class="font-semibold mb-2">This project is supported by:</p>
        <a href="https://m.do.co/c/8bd90b1b884d">
          <img src="https://opensource.nyc3.cdn.digitaloceanspaces.com/attribution/assets/SVG/DO_Logo_horizontal_blue.svg" width="201px">
        </a>
      </div>
      <div class="opensource-link">
        <p class="text-center text-secondary m-0">
          &copy; 2024 LinkFree by
          <a href="https://chriskthomas.com" rel="author" class="text-gray-400 hover:underline">Chris K. Thomas</a>
        </p>
      </div>
      <div class="other-links flex flex-col">
        <a href="https://github.com/chriskthomas/linkfree-generator" class="flex items-center hover:text-gray-500" rel="self"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-github mr-1"><path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/><path d="M9 18c-4.51 2-5-2-7-2"/></svg>Contribution</a>

        <a href="https://chriskthomas.github.io/linkfree-generator/" class="flex items-center mt-1.5 hover:text-gray-500"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-external-link mr-1"><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>Host LinkFree</a>
      </div>
    </div>
  </footer>
  <script src="js/index.js"></script>
</body>
</html>