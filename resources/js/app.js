import Chart from 'chart.js/auto';

const tempSeries = {
    hot: [70, 70.4, 69.8, 70.2, 70.1, 69.7, 70.3, 70],
    cold: [28, 28.2, 27.8, 28.1, 28.3, 27.9, 28.1, 28],
    mixed: [45, 44.8, 45.2, 45.1, 44.9, 45.3, 45, 45.1],
};

const chartColors = {
    hot: '#ac2bd4',
    cold: '#30cfb7',
    mixed: '#8a23a9',
    grid: 'rgba(131, 226, 212, 0.20)',
    text: '#d6f5f1',
};

function setupLoginForm() {
    const form = document.querySelector('[data-login-form]');

    if (!form) {
        return;
    }
}

function setupRegisterForm() {
    const form = document.querySelector('[data-register-form]');

    if (!form) {
        return;
    }

    const status = document.querySelector('[data-register-status]');

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const data = new FormData(form);
        const password = String(data.get('password') || '');
        const passwordConfirm = String(data.get('passwordConfirm') || '');

        if (password !== passwordConfirm) {
            status.textContent = 'Password dan konfirmasi password belum sama.';
            status.className = 'rounded-lg bg-[#f7eafb] px-4 py-3 text-xs font-bold text-[#8a23a9]';
            return;
        }

        const account = {
            name: data.get('name'),
            email: data.get('email'),
            className: data.get('className'),
            nis: data.get('nis'),
            major: data.get('major'),
            createdAt: new Date().toISOString(),
        };

        localStorage.setItem('asas-black-student-account', JSON.stringify(account));
        status.textContent = `Akun ${account.name} berhasil dibuat secara dummy. Email: ${account.email}, NIS: ${account.nis}, Kelas: ${account.className}, Jurusan: ${account.major}.`;
        status.className = 'rounded-lg bg-[#d6f5f1] px-4 py-3 text-xs font-bold text-[#1d7c6e]';
    });
}

function nextValue(values) {
    const last = values[values.length - 1];
    const jitter = (Math.random() - 0.5) * 0.7;
    return Number((last + jitter).toFixed(1));
}

function makeTemperatureChart(canvasId) {
    const canvas = document.getElementById(canvasId);

    if (!canvas || typeof Chart === 'undefined') {
        return null;
    }

    const labels = ['00:01', '00:02', '00:03', '00:04', '00:05', '00:06', '00:07', '00:08'];

    const chart = new Chart(canvas, {
        type: 'line',
        data: {
            labels,
            datasets: [
                {
                    label: 'Suhu Panas',
                    data: [...tempSeries.hot],
                    borderColor: chartColors.hot,
                    backgroundColor: 'rgba(172, 43, 212, 0.12)',
                    borderWidth: 3,
                    tension: 0.42,
                    pointRadius: 3,
                    fill: true,
                },
                {
                    label: 'Suhu Dingin',
                    data: [...tempSeries.cold],
                    borderColor: chartColors.cold,
                    backgroundColor: 'rgba(48, 207, 183, 0.10)',
                    borderWidth: 3,
                    tension: 0.42,
                    pointRadius: 3,
                    fill: true,
                },
                {
                    label: 'Suhu Campuran',
                    data: [...tempSeries.mixed],
                    borderColor: chartColors.mixed,
                    backgroundColor: 'rgba(138, 35, 169, 0.10)',
                    borderWidth: 3,
                    tension: 0.42,
                    pointRadius: 3,
                    fill: true,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 850,
                easing: 'easeOutQuart',
            },
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    labels: {
                        color: chartColors.text,
                        usePointStyle: true,
                        boxWidth: 8,
                        font: {
                            weight: 'bold',
                        },
                    },
                },
                tooltip: {
                    callbacks: {
                        label: (context) => `${context.dataset.label}: ${context.formattedValue} C`,
                    },
                },
            },
            scales: {
                x: {
                    grid: {
                        color: chartColors.grid,
                    },
                    ticks: {
                        color: chartColors.text,
                        font: {
                            weight: 'bold',
                        },
                    },
                },
                y: {
                    suggestedMin: 20,
                    suggestedMax: 78,
                    grid: {
                        color: chartColors.grid,
                    },
                    ticks: {
                        color: chartColors.text,
                        callback: (value) => `${value} C`,
                    },
                },
            },
        },
    });

    setInterval(() => {
        const date = new Date();
        const label = `${String(date.getMinutes()).padStart(2, '0')}:${String(date.getSeconds()).padStart(2, '0')}`;

        chart.data.labels.push(label);
        chart.data.labels.shift();

        chart.data.datasets.forEach((dataset, index) => {
            dataset.data.push(nextValue(dataset.data));
            dataset.data.shift();

            if (index === 0) {
                dataset.data[dataset.data.length - 1] = Math.min(72, Math.max(68, dataset.data[dataset.data.length - 1]));
            }

            if (index === 1) {
                dataset.data[dataset.data.length - 1] = Math.min(30, Math.max(26, dataset.data[dataset.data.length - 1]));
            }

            if (index === 2) {
                dataset.data[dataset.data.length - 1] = Math.min(47, Math.max(43, dataset.data[dataset.data.length - 1]));
            }
        });

        chart.update();
    }, 2200);

    return chart;
}

function setupCharts() {
    ['teacherRealtimeChart', 'studentRealtimeChart', 'monitoringChart'].forEach(makeTemperatureChart);
}

function setupTemperatureJitter() {
    const values = document.querySelectorAll('[data-temp-value]');

    if (!values.length) {
        return;
    }

    setInterval(() => {
        values.forEach((element) => {
            const base = Number(element.dataset.base || element.textContent || 0);
            const jitter = (Math.random() - 0.5) * 0.8;
            element.textContent = (base + jitter).toFixed(1);
        });
    }, 1800);
}

function formatJoules(value) {
    return `${Math.round(value).toLocaleString('id-ID')} J`;
}

function calculateAsasBlack(form) {
    const hotMass = Number(form.elements.hotMass?.value || 0);
    const coldMass = Number(form.elements.coldMass?.value || 0);
    const hasValidInput = hotMass > 0 && coldMass > 0;
    const t1 = 70;
    const t2 = 28;
    const tc = 45;
    const c = 4200;
    const qRelease = hasValidInput ? hotMass * c * (t1 - tc) : 0;
    const qAccept = hasValidInput ? coldMass * c * (tc - t2) : 0;
    const average = (qRelease + qAccept) / 2 || 1;
    const errorPercent = Math.abs(qRelease - qAccept) / average * 100;
    const isValid = hasValidInput && errorPercent <= 8;
    const container = form.closest('[data-page]') || document;

    container.querySelectorAll('[data-q-release]').forEach((item) => {
        item.textContent = formatJoules(qRelease);
    });

    container.querySelectorAll('[data-q-accept]').forEach((item) => {
        item.textContent = formatJoules(qAccept);
    });

    container.querySelectorAll('[data-delta-q]').forEach((item) => {
        item.textContent = hasValidInput ? formatJoules(Math.abs(qRelease - qAccept)) : '-';
    });

    container.querySelectorAll('[data-error-percent]').forEach((item) => {
        item.textContent = hasValidInput ? `${errorPercent.toFixed(2)}%` : '-';
    });

    container.querySelectorAll('[data-asas-status]').forEach((item) => {
        item.textContent = hasValidInput ? (isValid ? 'Sesuai Asas Black' : 'Belum Sesuai') : 'Masukkan massa valid';
        item.classList.toggle('text-[#30cfb7]', isValid);
        item.classList.toggle('dark:text-[#83e2d4]', isValid);
        item.classList.toggle('text-[#8a23a9]', hasValidInput && !isValid);
        item.classList.toggle('dark:text-[#cd80e5]', hasValidInput && !isValid);
        item.classList.toggle('text-[#135349]', !hasValidInput);
        item.classList.toggle('dark:text-[#d6f5f1]', !hasValidInput);
    });

    container.querySelectorAll('[data-asas-status-pill]').forEach((item) => {
        item.classList.toggle('border-[#acece2]', isValid);
        item.classList.toggle('bg-[#d6f5f1]', isValid);
        item.classList.toggle('text-[#1d7c6e]', isValid);
        item.classList.toggle('border-[#f7eafb]', hasValidInput && !isValid);
        item.classList.toggle('bg-[#f7eafb]', hasValidInput && !isValid);
        item.classList.toggle('text-[#8a23a9]', hasValidInput && !isValid);
        item.classList.toggle('border-[#acece2]', !hasValidInput);
        item.classList.toggle('bg-[#eafaf8]', !hasValidInput);
        item.classList.toggle('text-[#135349]', !hasValidInput);
    });

    container.querySelectorAll('[data-asas-note]').forEach((item) => {
        item.textContent = hasValidInput
            ? `Rumus aktif: ${hotMass} x 4200 x (70 - 45) dibandingkan ${coldMass} x 4200 x (45 - 28).`
            : 'Isi massa air panas dan massa air dingin lebih dari 0 kg untuk menghitung.';
    });

    return {
        hotMass,
        coldMass,
        qRelease,
        qAccept,
        deltaQ: Math.abs(qRelease - qAccept),
        errorPercent,
        status: isValid ? 'Sesuai Asas Black' : 'Belum Sesuai',
        hasValidInput,
    };
}

async function savePraktikumHistory(form, result) {
    const saveUrl = form.dataset.saveUrl;
    const container = form.closest('[data-page]') || document;
    const status = container.querySelector('[data-save-status]');

    if (!saveUrl || !status) {
        return;
    }

    if (!result.hasValidInput) {
        status.textContent = 'Riwayat belum disimpan karena massa air belum valid.';
        status.className = 'mt-3 rounded-lg bg-[#f7eafb] px-4 py-3 text-xs font-bold text-[#8a23a9]';
        return;
    }

    status.textContent = 'Menyimpan riwayat praktikum ke database...';
    status.className = 'mt-3 rounded-lg bg-[#d6f5f1] px-4 py-3 text-xs font-bold text-[#1d7c6e]';

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const payload = {
        massa_panas: result.hotMass,
        massa_dingin: result.coldMass,
        q_lepas: result.qRelease,
        q_terima: result.qAccept,
        delta_q: result.deltaQ,
        error_persen: result.errorPercent,
        status: result.status,
    };

    try {
        const response = await fetch(saveUrl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
            },
            body: JSON.stringify(payload),
        });

        if (response.status === 401) {
            status.textContent = 'Silakan login sebagai siswa agar riwayat tersimpan.';
            status.className = 'mt-3 rounded-lg bg-[#f7eafb] px-4 py-3 text-xs font-bold text-[#8a23a9]';
            return;
        }

        if (!response.ok) {
            throw new Error('save failed');
        }

        const data = await response.json();
        status.textContent = `${data.message} ID riwayat: ${data.history_id}.`;
        status.className = 'mt-3 rounded-lg bg-[#d6f5f1] px-4 py-3 text-xs font-bold text-[#1d7c6e]';
    } catch (error) {
        status.textContent = 'Riwayat gagal disimpan. Periksa koneksi backend dan coba lagi.';
        status.className = 'mt-3 rounded-lg bg-[#f7eafb] px-4 py-3 text-xs font-bold text-[#8a23a9]';
    }
}

function setupAsasBlackCalculator() {
    document.querySelectorAll('[data-asas-form]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const result = calculateAsasBlack(form);
            savePraktikumHistory(form, result);
        });

        form.querySelectorAll('input').forEach((input) => {
            input.addEventListener('input', () => calculateAsasBlack(form));
        });

        form.querySelector('[data-reset-asas]')?.addEventListener('click', () => {
            form.elements.hotMass.value = '0.25';
            form.elements.coldMass.value = '0.35';
            calculateAsasBlack(form);
        });

        calculateAsasBlack(form);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    setupLoginForm();
    setupRegisterForm();
    setupCharts();
    setupTemperatureJitter();
    setupAsasBlackCalculator();
});
