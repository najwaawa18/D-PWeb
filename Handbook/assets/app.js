const reader = document.getElementById('reader');
const menuButtons = [...document.querySelectorAll('[data-doc]')];
const search = document.getElementById('search');
const sidebar = document.getElementById('sidebar');
const mobileMenu = document.getElementById('mobileMenu');

function escapeHtml(value) {
    return value
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

function inline(text) {
    return escapeHtml(text)
        .replace(/`([^`]+)`/g, '<code>$1</code>')
        .replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>')
        .replace(/\*([^*]+)\*/g, '<em>$1</em>');
}

function markdownToHtml(md) {
    // Pecah Markdown berdasarkan baris
    const lines = md.replace(/\r?\n/g, '\n').split('\n');

    let html = '<div class="markdown">';
    let inCode = false;
    let code = [];
    let list = false;
    let table = false;

    const closeList = () => {
        if (list) {
            html += '</ul>';
            list = false;
        }
    };

    const closeTable = () => {
        if (table) {
            html += '</tbody></table>';
            table = false;
        }
    };

    for (let i = 0; i < lines.length; i++) {
        const line = lines[i];

        // CODE BLOCK
        if (line.startsWith('```')) {
            if (!inCode) {
                closeList();
                closeTable();
                inCode = true;
                code = [];
            } else {
                html += '<pre><code>' +
                    escapeHtml(code.join('\n')) +
                    '</code></pre>';

                inCode = false;
            }

            continue;
        }

        if (inCode) {
            code.push(line);
            continue;
        }

        // BARIS KOSONG
        if (!line.trim()) {
            closeList();
            closeTable();
            continue;
        }

        // TABLE
        if (/^\|.*\|$/.test(line)) {
            const cells = line
                .split('|')
                .slice(1, -1)
                .map(x => x.trim());

            // Skip garis pemisah Markdown table
            if (/^[-: ]+$/.test(cells.join(''))) {
                continue;
            }

            if (!table) {
                html += '<table><thead><tr>' +
                    cells.map(c => `<th>${inline(c)}</th>`).join('') +
                    '</tr></thead><tbody>';

                table = true;
            } else {
                html += '<tr>' +
                    cells.map(c => `<td>${inline(c)}</td>`).join('') +
                    '</tr>';
            }

            continue;
        }

        closeTable();

        // HEADING
        const h = line.match(/^(#{1,3})\s+(.*)$/);

        if (h) {
            closeList();

            const level = h[1].length;

            html += `<h${level}>${inline(h[2])}</h${level}>`;

            continue;
        }

        // LIST
        if (/^[-*]\s+/.test(line)) {
            if (!list) {
                html += '<ul>';
                list = true;
            }

            html += `<li>${inline(
                line.replace(/^[-*]\s+/, '')
            )}</li>`;

            continue;
        }

        // BLOCKQUOTE
        if (/^>\s?/.test(line)) {
            closeList();

            html += `<blockquote>${inline(
                line.replace(/^>\s?/, '')
            )}</blockquote>`;

            continue;
        }

        // HORIZONTAL LINE
        if (/^---+$/.test(line.trim())) {
            closeList();
            html += '<hr>';
            continue;
        }

        // PARAGRAPH
        closeList();

        html += `<p>${inline(line)}</p>`;
    }

    closeList();
    closeTable();

    // Kalau code block belum ditutup
    if (inCode) {
        html += '<pre><code>' +
            escapeHtml(code.join('\n')) +
            '</code></pre>';
    }

    return html + '</div>';
}

async function openDoc(path, button) {
    reader.innerHTML =
        '<p class="loading">Memuat dokumentasi...</p>';

    menuButtons.forEach(b =>
        b.classList.remove('active')
    );

    if (button) {
        button.classList.add('active');
    }

    try {
        const res = await fetch(path);

        if (!res.ok) {
            throw new Error(
                `Dokumen tidak ditemukan (${res.status})`
            );
        }

        const md = await res.text();

        reader.innerHTML = markdownToHtml(md);

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

        sidebar.classList.remove('open');

    } catch (err) {
        reader.innerHTML = `
            <div class="welcome">
                <h2>Dokumen tidak dapat dibuka.</h2>
                <p>${escapeHtml(err.message)}</p>
            </div>
        `;
    }
}


// Semua tombol dokumentasi
menuButtons.forEach(button => {
    button.addEventListener('click', () => {
        openDoc(button.dataset.doc, button);
    });
});


// Mobile menu
if (mobileMenu) {
    mobileMenu.addEventListener('click', () => {
        sidebar.classList.toggle('open');
    });
}


// Search dokumentasi
if (search) {
    search.addEventListener('input', () => {
        const q = search.value.toLowerCase().trim();

        menuButtons.forEach(button => {
            const show =
                !q ||
                button.textContent
                    .toLowerCase()
                    .includes(q);

            button.style.display = show ? '' : 'none';
        });
    });
}