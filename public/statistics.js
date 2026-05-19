// Функция для определения типа устройства
function getDeviceType() {
    const ua = navigator.userAgent;
    if (/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i.test(ua)) {
        return "Tablet";
    }
    if (/Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Kindle|Silk-Accelerated|(hpw|web)OS|Opera M(obi|ini)/.test(ua)) {
        return "Mobile";
    }
    return "Desktop";
}

// Функция для получения IP и города через публичный API (без VPN)
async function getGeoInfo() {
    try {
        // Используем стабильный API для геолокации
        const response = await fetch('https://ip-api.com/json/');
        const data = await response.json();
        return {
            ip: data.query,
            city: data.city
        };
    } catch (error) {
        console.error('Ошибка получения гео-данных:', error);
        return {
            ip: 'unknown',
            city: 'unknown'
        };
    }
}

// Основная функция отправки статистики
async function sendStatistics() {
    const device = getDeviceType();
    const geo = await getGeoInfo();
    
    const data = {
        ip: geo.ip,
        city: geo.city,
        device: device
    };

    try {
        await fetch('/api/statistics', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });
        console.log('Статистика отправлена');
    } catch (error) {
        console.error('Ошибка отправки:', error);
    }
}

sendStatistics();