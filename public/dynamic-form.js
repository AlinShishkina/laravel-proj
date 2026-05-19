/**
 * Алгоритм 1: Фильтрация по маске атрибута name.
 *
 * Почему этот алгоритм?
 * - Он точен и предсказуем, так как полагается на жестко заданную структуру.
 * - Он не зависит от порядка полей на странице.
 * - Он позволяет гибко группировать поля без изменения HTML-разметки.
 *
 * Альтернативные решения и причины отказа:
 *
 * 1. Использовать data-атрибуты: <input data-type="1" />
 *    - Более гибкий подход, так как не привязан к именам полей.
 *    - Отказался, так как требует изменения HTML-разметки, что запрещено условием задачи.
 *
 * 2. Использовать классы CSS (class="field-type-1"):
 *    - Простой и очевидный метод.
 *    - Проблема: может случайно захватить другие элементы, где этот класс используется для стилизации.
 *      Альтернатива с атрибутом name более явная и не вызывает таких коллизий.
 *
 * 3. Использовать контейнеры: оборачивать поля в <div data-type="1">
 *    - Тоже потребовал бы изменения HTML-структуры.
 *
 * 4. Индексировать поля по порядку с помощью массива:
 *    - Самый простой, но крайне ненадежный способ.
 *    - Если разработчик добавит или уберет поле, логика нарушится.
 *    - Отказался из-за негибкости и зависимости от порядка элементов.
 */

$(document).ready(function() {
    // Находим select по атрибуту name="type_val"
    const $select = $('select[name="type_val"]');
    
    // Все поля ввода (текстовые и кнопки) – скрывать/показывать будем их родительские <p>
    const $allFields = $('input[type="text"], input[type="button"]');

    /**
     * Проверяет, должно ли поле быть видимым при выбранном типе.
     * @param {HTMLElement} element - поле ввода
     * @param {number} selectedType - выбранное значение из select
     * @returns {boolean}
     */
    function shouldShowField(element, selectedType) {
        const name = $(element).attr('name');
        if (!name) return false;

        // Ищем в конце имени подчеркивание и число: _1, _12, _123
        const match = name.match(/_(\d+)$/);
        if (match) {
            const fieldSuffix = parseInt(match[1], 10);
            return fieldSuffix === selectedType;
        }
        return false;
    }

    // Фильтруем поля: скрываем те, чей суффикс не совпадает с выбранным типом
    function filterFields() {
        const selectedType = parseInt($select.val(), 10);

        $allFields.each(function() {
            const $field = $(this);
            const $paragraph = $field.closest('p'); // Родительский абзац

            if (shouldShowField(this, selectedType)) {
                $paragraph.show();
            } else {
                $paragraph.hide();
            }
        });
    }

    // Подписываемся на изменение select
    $select.on('change', filterFields);
    // Вызываем сразу, чтобы применить фильтр при загрузке страницы
    filterFields();
});