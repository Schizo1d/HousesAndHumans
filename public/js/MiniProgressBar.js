// Функция обновления мини-прогресс бара
function updateMiniProgressBar() {
    const nextLevel = currentLevel + 1;
    const currentLevelXp = XP_TABLE[currentLevel] || 0;
    const nextLevelXp = XP_TABLE[nextLevel] || XP_TABLE[20];
    const xpInLevel = currentXp - currentLevelXp;
    const xpNeeded = nextLevelXp - currentLevelXp;
    const progressPercent = (xpInLevel / xpNeeded) * 100;

    // Обновляем мини-прогресс бар
    const miniProgressBar = document.getElementById('mini-xp-progress-bar');
    miniProgressBar.style.width = `${Math.min(100, progressPercent)}%`;

    // Обновляем текст
    document.getElementById('mini-xp-progress-text').textContent =
        `${xpInLevel}/${xpNeeded}`;
}

// Обновляем функцию updateAllProgress
function updateAllProgress() {
    updateXpDisplay();
    updateProgressBar();
    updateMiniProgressBar(); // Добавляем вызов обновления мини-прогресс бара
    checkLevelUp();
}

// Вызываем при загрузке страницы
document.addEventListener("DOMContentLoaded", function() {
    currentLevel = {{ $character->level ?? 1 }};
    currentXp = {{ $character->experience ?? 0 }};
    updateAllProgress();
});
