// Глобальные переменные
const levelUpModal = document.getElementById('level-up-modal');
const levelUpBtn = document.querySelector('.level-up-btn');
let isLevelUpModalOpen = false;
let currentLevel = {{ $character->level ?? 1 }};
let currentXp = {{ $character->experience ?? 0 }};
let currentExpression = '0';
const characterId = document.querySelector('meta[name="character-id"]').getAttribute('content');
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const XP_TABLE = {
    1: 0,
    2: 300,
    3: 900,
    4: 2700,
    5: 6500,
    6: 14000,
    7: 23000,
    8: 34000,
    9: 48000,
    10: 64000,
    11: 85000,
    12: 100000,
    13: 120000,
    14: 140000,
    15: 165000,
    16: 195000,
    17: 225000,
    18: 265000,
    19: 305000,
    20: 355000
};
let currentAttr = null;

const attributeNames = {
    strength: "Сила",
    dexterity: "Ловкость",
    constitution: "Телосложение",
    intelligence: "Интеллект",
    wisdom: "Мудрость",
    charisma: "Харизма"
};

// Открыть модальное окно для изменения значения атрибута
function openModal(attr) {
    currentAttr = attr;
    let value = document.getElementById(attr).value;
    document.getElementById("modal-title").innerText = attributeNames[attr] || attr;
    document.getElementById("modal-input").value = value;
    document.getElementById("attributeModal").style.display = "flex";
}

// Закрыть модальное окно
function closeModal() {
    document.getElementById("attributeModal").style.display = "none";
}


// Функция расчета модификатора атрибута (по правилам D&D)
function getModifier(attributeValue) {
    return Math.floor((attributeValue - 10) / 2);
}

// Общая функция для обработки всех радио-кнопок навыков
function handleSkillRadio(element, skillId, attributeId) {
    const hiddenInput = document.getElementById(skillId);
    const displaySpan = document.getElementById(skillId + '-value');
    const customRadio = element.nextElementSibling;

    // Циклическое изменение значения: 0 → 2 → 4 → 0
    let currentValue = parseInt(hiddenInput.value) || 0;
    let newValue;

    if (currentValue === 0) newValue = 2;
    else if (currentValue === 2) newValue = 4;
    else newValue = 0;

    // Обновляем скрытое поле
    hiddenInput.value = newValue;

    // Рассчитываем итоговое значение с модификатором атрибута
    const attributeValue = parseInt(document.getElementById(attributeId).value) || 10;
    const modifier = Math.floor((attributeValue - 10) / 2);
    const finalValue = modifier + newValue;

    // Обновляем отображаемое значение
    displaySpan.textContent = finalValue;

    // Обновляем визуальное состояние радио-кнопки
    customRadio.classList.remove('half-checked', 'fully-checked');
    if (newValue === 2) {
        customRadio.classList.add('half-checked');
    } else if (newValue === 4) {
        customRadio.classList.add('fully-checked');
    }

    // Предотвращаем стандартное поведение checkbox
    element.checked = false;
}

// Инициализация состояний при загрузке страницы
document.addEventListener("DOMContentLoaded", function () {
    // Навыки силы
    initSkillRadio('athletics');

    // Навыки ловкости
    initSkillRadio('acrobatics');
    initSkillRadio('sleight_of_hand');
    initSkillRadio('stealth');

    // Навыки интеллекта
    initSkillRadio('investigation');
    initSkillRadio('history');
    initSkillRadio('arcana');
    initSkillRadio('nature');
    initSkillRadio('religion');

    // Навыки мудрости
    initSkillRadio('perception');
    initSkillRadio('survival');
    initSkillRadio('medicine');
    initSkillRadio('insight');
    initSkillRadio('animal_handling');

    // Навыки харизмы
    initSkillRadio('performance');
    initSkillRadio('intimidation');
    initSkillRadio('deception');
    initSkillRadio('persuasion');
});

// Функция инициализации радио-кнопки навыка
function initSkillRadio(skillId) {
    const skillValue = parseInt(document.getElementById(skillId).value) || 0;
    const radioCustom = document.querySelector('#' + skillId + '-radio + .double-radio-custom');

    if (!radioCustom) return;

    radioCustom.classList.remove('half-checked', 'fully-checked');
    if (skillValue === 2) {
        radioCustom.classList.add('half-checked');
    } else if (skillValue === 4) {
        radioCustom.classList.add('fully-checked');
    }
}

document.querySelectorAll('.skill-toggle').forEach(item => {
    item.addEventListener('click', function () {
        let targetId = this.getAttribute('data-target');
        let span = document.getElementById(targetId + "-value");
        let input = document.getElementById(targetId);

        // Циклически меняем бонус владения: 0 -> 2 -> 4 -> 0
        let currentValue = parseInt(input.value);
        let newValue = currentValue === 4 ? 0 : currentValue + 2;
        input.value = newValue;

        // Найти родительский атрибут
        let attribute = Object.keys(attributeNames).find(attr =>
            document.getElementById(attr) && this.closest('.attribute-item').contains(document.getElementById(attr))
        );

        let attributeValue = parseInt(document.getElementById(attribute).value);
        let modifier = getModifier(attributeValue);
        let finalValue = modifier + newValue;

        // Отображаем итоговое значение (модификатор + бонус)
        span.innerText = finalValue;
    });
});
document.addEventListener("DOMContentLoaded", function () {
    Object.keys(attributeNames).forEach(attr => {
        updateModifier(attr);
        updateSkills(attr);
    });
});

function updateSkills(attribute) {
    let attrValue = parseInt(document.getElementById(attribute).value);
    let modifier = getModifier(attrValue);

    let skills = {
        strength: ["athletics"],
        dexterity: ["acrobatics", "sleight_of_hand", "stealth"],
        intelligence: ["investigation", "history", "arcana", "nature", "religion"],
        wisdom: ["perception", "survival", "medicine", "insight", "animal_handling"],
        charisma: ["performance", "intimidation", "deception", "persuasion"]
    };

    if (skills[attribute]) {
        skills[attribute].forEach(skill => {
            let skillBonus = parseInt(document.getElementById(skill).value);
            let finalValue = modifier + skillBonus;
            document.getElementById(skill + "-value").innerText = finalValue;
        });
    }
}

function toggleSkill(element) {
    const targetId = element.getAttribute('data-target');
    const span = document.getElementById(targetId + "-value");
    const input = document.getElementById(targetId);

    // Циклическое изменение значения: 0 → 2 → 4 → 0
    let currentValue = parseInt(input.value);
    let newValue = currentValue === 4 ? 0 : currentValue + 2;
    input.value = newValue;

    // Находим связанный атрибут
    const attribute = Object.keys(attributeNames).find(attr =>
        element.closest('.attribute-item').contains(document.getElementById(attr))
    );

    // Рассчитываем итоговое значение
    const attributeValue = parseInt(document.getElementById(attribute).value);
    const modifier = Math.floor((attributeValue - 10) / 2);
    const finalValue = modifier + newValue;

    // Обновляем отображение
    span.textContent = finalValue;
}

function rollDice(attribute) {
    const value = parseInt(document.getElementById(attribute).value) || 10; // Значение по умолчанию 10
    const modifier = Math.floor((value - 10) / 2);
    const roll = Math.floor(Math.random() * 20) + 1;
    const total = roll + modifier;

    addNotification(
        'ПРОВЕРКА',
        attribute,
        roll,
        modifier,
        total
    );
}

function rollSave(attribute) {
    const value = parseInt(document.getElementById(attribute).value) || 10; // Значение по умолчанию 10
    const modifier = Math.floor((value - 10) / 2);
    const roll = Math.floor(Math.random() * 20) + 1;
    const total = roll + modifier;

    addNotification(
        'СПАСБРОСОК',
        attribute,
        roll,
        modifier,
        total
    );
}

// Функция для броска навыка
function rollSkill(skill, attribute) {
    const skillBonus = parseInt(document.getElementById(skill).value) || 0;
    const attrValue = parseInt(document.getElementById(attribute).value) || 10;
    const attrModifier = Math.floor((attrValue - 10) / 2);
    const roll = Math.floor(Math.random() * 20) + 1;
    const total = roll + attrModifier + skillBonus;

    // Переводим название навыка
    const skillNames = {
        'athletics': 'АТЛЕТИКА',
        'acrobatics': 'АКРОБАТИКА',
        'sleight_of_hand': 'ЛОВКОСТЬ РУК',
        'stealth': 'СКРЫТНОСТЬ',
        'investigation': 'АНАЛИЗ',
        'history': 'ИСТОРИЯ',
        'arcana': 'МАГИЯ',
        'nature': 'ПРИРОДА',
        'religion': 'РЕЛИГИЯ',
        'perception': 'ВОСПРИЯТИЕ',
        'survival': 'ВЫЖИВАНИЕ',
        'medicine': 'МЕДИЦИНА',
        'insight': 'ПРОНИЦАТЕЛЬНОСТЬ',
        'animal_handling': 'УХОД ЗА ЖИВОТНЫМИ',
        'performance': 'ВЫСТУПЛЕНИЕ',
        'intimidation': 'ЗАПУГИВАНИЕ',
        'deception': 'ОБМАН',
        'persuasion': 'УБЕЖДЕНИЕ'
    };

    addNotification(
        'НАВЫК',
        skillNames[skill] || skill,
        roll,
        attrModifier + skillBonus,
        total
    );
}

// Функция для перевода названий атрибутов
function attributeName(attr) {
    const names = {
        'strength': 'СИЛА',
        'dexterity': 'ЛОВКОСТЬ',
        'constitution': 'ТЕЛОСЛОЖЕНИЕ',
        'intelligence': 'ИНТЕЛЛЕКТ',
        'wisdom': 'МУДРОСТЬ',
        'charisma': 'ХАРИЗМА'
    };
    return names[attr] || attr;
}


function updateModifier(attribute) {
    let attrValue = parseInt(document.getElementById(attribute).value);
    let modifier = getModifier(attrValue);
    document.getElementById(`${attribute}-modifier`).textContent = modifier;
    document.getElementById(`${attribute}-save-modifier`).textContent = modifier;
}

function saveAttribute() {
    let value = parseInt(document.getElementById("modal-input").value);
    if (!currentAttr) return;

    document.getElementById(`${currentAttr}-button`).textContent = value;
    document.getElementById(currentAttr).value = value;

    updateModifier(currentAttr);
    updateSkills(currentAttr);

    closeModal();
}

document.addEventListener("DOMContentLoaded", function () {
    Object.keys(attributeNames).forEach(attr => updateModifier(attr));
});
document.addEventListener("DOMContentLoaded", function () {
    const characterAvatar = document.getElementById("character-avatar");
    const dropdown = document.getElementById("character-dropdown");

    characterAvatar.addEventListener("click", function (event) {
        event.stopPropagation();
        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    });

    document.addEventListener("click", function () {
        dropdown.style.display = "none";
    });

    dropdown.addEventListener("click", function (event) {
        event.stopPropagation();
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const settingsBtn = document.getElementById("settings-btn");
    const sidebarModal = document.getElementById("settings-modal");
    const closeSidebar = document.getElementById("close-sidebar");

    // В обработчике открытия модального окна настроек
    settingsBtn.addEventListener("click", function () {
        const backdrop = document.getElementById('settings-backdrop');
        backdrop.style.display = 'block';
        setTimeout(() => {
            sidebarModal.classList.add("show");
            backdrop.classList.add('active');
        }, 10);
    });

    // В обработчике закрытия
    closeSidebar.addEventListener("click", function () {
        const backdrop = document.getElementById('settings-backdrop');
        sidebarModal.classList.remove("show");
        backdrop.classList.remove('active');
        setTimeout(() => {
            backdrop.style.display = 'none';
        }, 300);
    });

    // Обновите обработчик клика вне модального окна
    document.addEventListener("click", function (event) {
        const backdrop = document.getElementById('settings-backdrop');
        if (!sidebarModal.contains(event.target) &&
            !settingsBtn.contains(event.target) &&
            backdrop.classList.contains('active')) {
            sidebarModal.classList.remove("show");
            backdrop.classList.remove('active');
            setTimeout(() => {
                backdrop.style.display = 'none';
            }, 300);
        }
    });
    document.getElementById('save-character-settings').addEventListener('click', function () {
        const characterId = {{ $character->id }};
        const name = document.getElementById('character-name-input').value;
        const race = document.getElementById('character-race-input').value;
        const characterClass = document.getElementById('character-class-input').value;
        const subclass = document.getElementById('character-subclass-input').value;

        fetch('/characters/update-settings', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                character_id: characterId,
                name: name,
                race: race,
                class: characterClass,
                subclass: subclass
            })
        })
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const nameInput = document.getElementById("character-name-input");
    const saveButton = document.getElementById("save-character-name");
    const saveMessage = document.getElementById("save-message");
    const characterNameElement = document.querySelector(".character-name h2");

    saveButton.addEventListener("click", function () {
        const newName = nameInput.value.trim();

        // Проверка, чтобы имя не было пустым
        if (newName === "") {
            alert("Имя не может быть пустым!");
            return;
        }

        // ID персонажа
        const characterId = document.querySelector('meta[name="character-id"]').getAttribute("content");

        // Отправляем запрос
        fetch("/character/update-name", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({name: newName, character_id: characterId})
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    characterNameElement.textContent = data.newName; // Меняем имя на странице
                    saveMessage.textContent = "Имя сохранено!";
                    saveMessage.style.color = "#28a745"; // Зеленый цвет успеха
                } else {
                    saveMessage.textContent = "Ошибка!";
                    saveMessage.style.color = "red";
                }
                saveMessage.style.display = "block";
                setTimeout(() => saveMessage.style.display = "none", 2000);
            })
            .catch(error => console.error("Ошибка:", error));
    });
});
const MAX_NOTIFICATIONS = 4;
let currentNotifications = 0;

function addNotification(type, attribute, roll, modifier, result) {
    const container = document.getElementById('notificationsContainer');
    const closeBtn = document.querySelector('.close-all-btn');

    const isCheck = type === 'ПРОВЕРКА';
    const typeClass = isCheck ? 'check-text' : 'save-text';
    const notificationType = isCheck ? 'check' : 'save';
    const modifierDisplay = modifier >= 0 ? `+ ${modifier}` : modifier;

    // Преобразуем старые уведомления
    document.querySelectorAll('.notification.new').forEach(notif => {
        const oldTypeClass = notif.dataset.notificationType === 'check' ? 'check-text' : 'save-text';
        notif.className = `notification old ${notif.dataset.notificationType}`;
        notif.innerHTML = `
            <span>${notif.dataset.result} </span>
            <span class="${oldTypeClass}">${notif.dataset.type}</span>
            <span> ${notif.dataset.attribute}</span>
        `;
    });

    // Создаем новое уведомление
    const notification = document.createElement('div');
    notification.className = 'notification new';
    notification.dataset.type = type;
    notification.dataset.attribute = attributeName(attribute);
    notification.dataset.result = result;
    notification.dataset.notificationType = notificationType;

    notification.innerHTML = `
        <div class="notification-header">
            <span class="${typeClass}">${type}</span> ${attributeName(attribute)}
        </div>
        <div class="notification-content">
            <div class="notification-formula">${roll} ${modifierDisplay}</div>
            <div class="notification-result">${result}</div>
        </div>
    `;

    container.insertBefore(notification, container.firstChild);

    // Лимит уведомлений
    while (container.children.length > MAX_NOTIFICATIONS) {
        container.lastChild.remove();
    }
    if (container.children.length === 1) {
        document.querySelector('.close-all-btn').classList.add('visible');
    }
}

// Показываем/скрываем крестик при наличии уведомлений
function clearAllNotifications() {
    const container = document.getElementById('notificationsContainer');
    container.innerHTML = '';
    currentNotifications = 0;
}

function showBottomLeftAlert(header, formula, result) {
    const alertElement = document.getElementById('bottomLeftAlert');
    document.getElementById('alertHeader').textContent = header;
    document.getElementById('rollFormula').textContent = formula;
    document.getElementById('rollResult').textContent = result;
    alertElement.style.display = 'block';
}

function hideBottomLeftAlert() {
    document.getElementById('bottomLeftAlert').style.display = 'none';
}

function showCustomAlert(message) {
    document.getElementById('customAlertMessage').textContent = message;
    document.getElementById('customAlertOverlay').style.display = 'block';
    document.getElementById('customAlert').style.display = 'block';
}

function hideCustomAlert() {
    document.getElementById('customAlertOverlay').style.display = 'none';
    document.getElementById('customAlert').style.display = 'none';
}

// Добавляем обработчик для ручного управления видимостью
document.getElementById('notificationsWrapper').addEventListener('mouseenter', function () {
    if (this.querySelector('.notifications-container').children.length > 0) {
        this.querySelector('.close-all-btn').style.opacity = '1';
    }
});

document.getElementById('notificationsWrapper').addEventListener('mouseleave', function () {
    this.querySelector('.close-all-btn').style.opacity = '0';
});

function updateNotificationsState() {
    const wrapper = document.getElementById('notificationsWrapper');
    const hasNotifications = document.getElementById('notificationsContainer').children.length > 0;

    if (hasNotifications) {
        wrapper.classList.add('has-notifications');
    } else {
        wrapper.classList.remove('has-notifications');
    }
}

function hideCloseButtonInstantly() {
    const btn = document.querySelector('.close-all-btn');
    btn.style.transition = 'none'; // Отключаем анимацию
    btn.classList.remove('visible'); // Мгновенно скрываем
    setTimeout(() => {
        btn.style.transition = ''; // Восстанавливаем анимацию
    }, 10);
}

// Инициализация при открытии модального окна
function openLevelUpModal() {
    if (isLevelUpModalOpen) return;

    const modal = document.getElementById('level-up-modal');
    const backdrop = document.getElementById('modal-backdrop');

    backdrop.style.display = 'block';
    modal.style.display = 'block';

    setTimeout(() => {
        backdrop.classList.add('active');
        modal.classList.add('show');
        isLevelUpModalOpen = true;
    }, 10);

    updateProgressBar();
    document.getElementById('xp-input').value = '0';
    currentExpression = '0';
}



function closeLevelUpModal() {
    if (!isLevelUpModalOpen) return;

    const modal = document.getElementById('level-up-modal');
    const backdrop = document.getElementById('modal-backdrop');

    modal.classList.remove('show');
    backdrop.classList.remove('active');

    setTimeout(() => {
        modal.style.display = 'none';
        backdrop.style.display = 'none';
        isLevelUpModalOpen = false;
    }, 300);
}

// Обработчик открытия по кнопке
document.querySelector('.level-up-btn').addEventListener('click', function(e) {
    e.stopPropagation();
    openLevelUpModal();
});

// Обработчик закрытия по крестику
document.querySelector('#level-up-modal .modal-close-btn').addEventListener('click', function(e) {
    e.stopPropagation();
    closeLevelUpModal();
});

// Закрытие при клике на backdrop
document.getElementById('modal-backdrop').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLevelUpModal();
    }
});

// Защита от закрытия при клике внутри модального окна
document.getElementById('level-up-modal').addEventListener('click', function(e) {
    e.stopPropagation();
});

// Функция для изменения значения опыта
function changeXp(amount) {
    const input = document.getElementById('xp-input');
    if (!input) return;

    let value = parseInt(input.value) || 0;
    value = Math.max(0, value + amount);
    input.value = value;
}

// Функция для обновления уровня персонажа на сервере
function updateCharacterLevel(newLevel) {
    try {
        const characterId = document.querySelector('meta[name="character-id"]')?.getAttribute('content');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (!characterId || !csrfToken) {
            console.error('Missing required meta tags');
            return;
        }

        fetch('/character/update-level', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                character_id: characterId,
                level: newLevel
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    console.error('Ошибка при обновлении уровня:', data.error);
                    // Откатываем изменение на клиенте
                    const levelElement = document.querySelector('.character-level');
                    if (levelElement) {
                        levelElement.textContent = `Уровень ${newLevel - 1}`;
                    }
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                const levelElement = document.querySelector('.character-level');
                if (levelElement) {
                    levelElement.textContent = `Уровень ${newLevel - 1}`;
                }
            });
    } catch (error) {
        console.error('Error in updateCharacterLevel:', error);
    }
}
// Функции для работы с калькулятором
function appendNumber(num) {
    const input = document.getElementById('xp-input');
    if (!input) return;

    if (currentExpression === '0') {
        currentExpression = num.toString();
    } else {
        currentExpression += num.toString();
    }

    input.value = currentExpression;
}

function appendOperator(operator) {
    const input = document.getElementById('xp-input');
    if (!input) return;

    // Проверяем, не является ли последний символ оператором
    const lastChar = currentExpression.slice(-1);
    if (['+', '-'].includes(lastChar)) {
        // Заменяем последний оператор
        currentExpression = currentExpression.slice(0, -1) + operator;
    } else {
        currentExpression += operator;
    }

    input.value = currentExpression;
}

function calculateExpression() {
    try {
        // Безопасное вычисление выражения
        return eval(currentExpression.replace(/[^-+0-9]/g, '')) || 0;
    } catch (e) {
        console.error('Error calculating expression:', e);
        return 0;
    }
}

async function calculateAndAdd() {
    try {
        const amount = calculateExpression();
        if (amount <= 0) {
            alert('Введите положительное число');
            return;
        }

        currentXp += amount;
        await saveExperience(currentXp);

        // Сразу обновляем интерфейс без ожидания ответа сервера
        updateAllProgress();
        clearInput();

    } catch (error) {
        console.error('Add XP error:', error);
        currentXp -= amount; // Откатываем изменения
        alert('Ошибка: ' + (error.message || 'Не удалось добавить опыт'));
    } finally {
        updateAllProgress(); // Все равно обновляем на случай частичных изменений
    }
}

async function calculateAndSubtract() {
    try {
        const amount = calculateExpression();
        if (amount <= 0) {
            alert('Введите положительное число');
            return;
        }

        currentXp = Math.max(0, currentXp - amount);
        await saveExperience(currentXp);

        // Сразу обновляем интерфейс
        updateAllProgress();
        clearInput();

    } catch (error) {
        console.error('Subtract XP error:', error);
        currentXp += amount; // Откатываем изменения
        alert('Ошибка: ' + (error.message || 'Не удалось вычесть опыт'));
    } finally {
        updateAllProgress();
    }
}

function clearInput() {
    currentExpression = '0';
    document.getElementById('xp-input').value = currentExpression;
}

// Функция для прибавления опыта
async function addXp() {
    const input = document.getElementById('xp-input');
    if (!input) return;

    const amount = parseInt(input.value) || 0;
    if (amount <= 0) return;

    try {
        currentXp += amount;
        await saveExperience(currentXp);
        updateXpDisplay();
        checkLevelUp();
        input.value = "0";
    } catch (error) {
        // Откатываем изменения при ошибке
        currentXp -= amount;
        updateXpDisplay();
        alert('Ошибка при сохранении опыта');
    }
}
// Функция для вычитания опыта
async function subtractXp() {
    const input = document.getElementById('xp-input');
    if (!input) return;

    const amount = parseInt(input.value) || 0;
    if (amount <= 0) return;

    try {
        currentXp = Math.max(0, currentXp - amount);
        await saveExperience(currentXp);
        updateXpDisplay();
        checkLevelUp();
        input.value = "0";
    } catch (error) {
        // Откатываем изменения при ошибке
        currentXp += amount;
        updateXpDisplay();
        alert('Ошибка при сохранении опыта');
    }
}

// Обновление отображения текущего опыта
function updateXpDisplay() {
    const currentXpElement = document.getElementById('current-xp');
    if (currentXpElement) {
        currentXpElement.textContent = currentXp;
    }
}

// Проверка возможности повышения уровня
function checkLevelUp() {
    const currentLevel = parseInt(document.querySelector('.character-level')?.textContent.replace('Уровень ', '')) || 1;
    const nextLevel = currentLevel + 1;
    const xpRequired = XP_TABLE[nextLevel] || Infinity;

    document.getElementById('xp-required').textContent = Math.max(0, xpRequired - currentXp);
}
// Функция повышения уровня
async function levelUpCharacter() {
    const nextLevel = currentLevel + 1;
    const nextLevelXp = XP_TABLE[nextLevel] || XP_TABLE[20];

    if (currentXp >= nextLevelXp) {
        try {
            // Сохраняем на сервере
            const response = await saveExperience(currentXp, nextLevel);

            // Обновляем локальные значения
            currentLevel = nextLevel;

            // Обновляем отображение
            updateProgressBar();
            document.querySelector('.character-level').textContent = `Уровень ${currentLevel}`;

            // Показываем анимацию
            animateLevelUp();
        } catch (error) {
            alert('Ошибка при повышении уровня');
        }
    }
}
// Анимация повышения уровня
function animateLevelUp() {
    const progressBar = document.getElementById('xp-progress-bar');
    progressBar.style.transition = 'none';
    progressBar.style.width = '0%';

    setTimeout(() => {
        progressBar.style.transition = 'width 0.5s ease';
        updateProgressBar();
    }, 10);
}

// Функция обновления прогресс-бара
function updateProgressBar() {
    const nextLevel = currentLevel + 1;
    const currentLevelXp = XP_TABLE[currentLevel] || 0;
    const nextLevelXp = XP_TABLE[nextLevel] || XP_TABLE[20];
    const xpInLevel = currentXp - currentLevelXp;
    const xpNeeded = nextLevelXp - currentLevelXp;
    const progressPercent = (xpInLevel / xpNeeded) * 100;

    // Обновляем прогресс-бар с анимацией
    const progressBar = document.getElementById('xp-progress-bar');
    progressBar.style.transition = 'width 0.3s ease';
    progressBar.style.width = `${Math.min(100, progressPercent)}%`;

    // Обновляем текст
    document.getElementById('xp-progress-text').textContent =
        `${xpInLevel}/${xpNeeded} XP (${Math.round(progressPercent)}%)`;
    document.getElementById('xp-remaining').textContent = Math.max(0, xpNeeded - xpInLevel);
}


// Функция для сохранения опыта на сервере
async function saveExperience(newExperience, newLevel = null) {
    try {
        // Проверка ввода
        if (isNaN(newExperience) || newExperience < 0) {
            throw new Error('Некорректное значение опыта');
        }

        const data = {
            character_id: characterId,
            experience: newExperience
        };

        if (newLevel !== null) {
            if (newLevel < 1 || newLevel > 20) {
                throw new Error('Некорректный уровень');
            }
            data.level = newLevel;
        }

        const response = await fetch('/character/update-experience', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (!response.ok || !result.success) {
            throw new Error(result.error || 'Ошибка сервера');
        }

        return result;
    } catch (error) {
        console.error('Error saving experience:', error);
        throw error;
    }
}
function deleteLastChar() {
    const input = document.getElementById('xp-input');
    if (!input) return;

    if (currentExpression.length > 1) {
        currentExpression = currentExpression.slice(0, -1);
    } else {
        currentExpression = '0';
    }

    input.value = currentExpression;
}
function updateAllProgress() {
    updateXpDisplay();
    updateProgressBar();
    checkLevelUp();

    // Разблокируем кнопку, если опыта хватает
    const nextLevel = currentLevel + 1;
    const nextLevelXp = XP_TABLE[nextLevel] || XP_TABLE[20];
    const levelUpBtn = document.getElementById('level-up-btn');

    if (currentXp >= nextLevelXp) {
        levelUpBtn.disabled = false;
        levelUpBtn.classList.remove('disabled'); // На всякий случай убираем CSS-класс
    } else {
        levelUpBtn.disabled = true;
    }
}

document.addEventListener("DOMContentLoaded", function() {
    // Инициализируем значения
    currentLevel = {{ $character->level ?? 1 }};
    currentXp = {{ $character->experience ?? 0 }};

    // Первоначальное обновление интерфейса
    updateAllProgress();

    // Обработчики для кнопок
    document.getElementById('level-up-btn').addEventListener('click', levelUpCharacter);
});

document.getElementById('settings-backdrop').addEventListener('click', function() {
    const sidebarModal = document.getElementById('settings-modal');
    const backdrop = document.getElementById('settings-backdrop');
    sidebarModal.classList.remove("show");
    backdrop.classList.remove('active');
    setTimeout(() => {
        backdrop.style.display = 'none';
    }, 300);
});
