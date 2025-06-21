let currentPage = 1;
const storiesPerPage = 2;
let stories;

function showPage(page) {
  let start = (page - 1) * storiesPerPage;
  let end = start + storiesPerPage;

  stories.forEach((story, index) => {
    story.style.display = (index >= start && index < end) ? "block" : "none";
  });

  document.getElementById('page-num').innerText = `Page ${page}`;
}

function prevPage() {
  if (currentPage > 1) {
    currentPage--;
    showPage(currentPage);
  }
}

function nextPage() {
  if (currentPage < Math.ceil(stories.length / storiesPerPage)) {
    currentPage++;
    showPage(currentPage);
  }
}

document.addEventListener('DOMContentLoaded', () => {
  stories = Array.from(document.querySelectorAll('.story'));  // Make sure this gets all .story elements
  showPage(currentPage);
});
