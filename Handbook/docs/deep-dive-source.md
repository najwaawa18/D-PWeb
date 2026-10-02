# Deep Dive Source Code — Cafe_Najwa
Bagian ini dibuat dari source code yang diunggah. **Baca ini setelah memahami halaman utama handbook.**
## Cara membaca kode saat UTS
Gunakan pola: **Input → Validasi → Query/Proses → Database → Output/Redirect → Dampak**.
Jika dosen menunjuk satu baris, jelaskan fungsi baris tersebut lalu hubungkan dengan alur di atas.

## `Jobsheet12/config/database.php`
**Ukuran:** 104 baris. **Peran:** membangun koneksi PDO PostgreSQL dari environment variables.

### Kode asli (line-numbered)
```text
0001  <?php
0002  
0003  // ======================================================
0004  // LOAD .ENV UNTUK LOCALHOST
0005  // ======================================================
0006  
0007  $envFile = __DIR__ . '/../.env';
0008  
0009  if (file_exists($envFile)) {
0010  
0011      $lines = file(
0012          $envFile,
0013          FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
0014      );
0015  
0016      foreach ($lines as $line) {
0017  
0018          $line = trim($line);
0019  
0020          if (
0021              $line === '' ||
0022              str_starts_with($line, '#')
0023          ) {
0024              continue;
0025          }
0026  
0027          [$key, $value] = array_pad(
0028              explode('=', $line, 2),
0029              2,
0030              ''
0031          );
0032  
0033          $key = trim($key);
0034          $value = trim($value);
0035  
0036          if ($key !== '') {
0037              putenv("$key=$value");
0038          }
0039      }
0040  }
0041  
0042  
0043  // ======================================================
0044  // AMBIL KONFIGURASI DATABASE
0045  // ======================================================
0046  
0047  $host = getenv('DB_HOST');
0048  $port = getenv('DB_PORT') ?: '5432';
0049  $dbname = getenv('DB_NAME') ?: 'postgres';
0050  $username = getenv('DB_USER');
0051  $password = getenv('DB_PASSWORD');
0052  
0053  
0054  // ======================================================
0055  // KONEKSI DATABASE
0056  // ======================================================
0057  
0058  try {
0059  
0060      if (
0061          !$host ||
0062          !$username ||
0063          !$password
0064      ) {
0065  
0066          throw new Exception(
0067              "Environment variable database belum lengkap."
0068          );
0069      }
0070  
0071  
0072      $pdo = new PDO(
0073          "pgsql:host={$host};port={$port};dbname={$dbname};sslmode=require",
0074          $username,
0075          $password
0076      );
0077  
0078  
0079      $pdo->setAttribute(
0080          PDO::ATTR_ERRMODE,
0081          PDO::ERRMODE_EXCEPTION
0082      );
0083  
0084  
0085      $pdo->setAttribute(
0086          PDO::ATTR_DEFAULT_FETCH_MODE,
0087          PDO::FETCH_ASSOC
0088      );
0089  
0090  
0091  } catch (PDOException $e) {
0092  
0093      die(
0094          "Koneksi database gagal: " .
0095          $e->getMessage()
0096      );
0097  
0098  } catch (Exception $e) {
0099  
0100      die(
0101          "Konfigurasi database gagal: " .
0102          $e->getMessage()
0103      );
0104  }
```
### Pertanyaan dosen yang mungkin muncul
- Apa fungsi file ini dan apa akibatnya jika file ini tidak dipanggil?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/includes/auth.php`
**Ukuran:** 10 baris. **Peran:** middleware sederhana untuk memastikan user sudah login.

### Kode asli (line-numbered)
```text
0001  <?php
0002  
0003  if (session_status() === PHP_SESSION_NONE) {
0004      session_start();
0005  }
0006  
0007  if (!isset($_SESSION['user_id'])) {
0008      header("Location: /Jobsheet12/auth/login.php");
0009      exit;
0010  }
```
### Pertanyaan dosen yang mungkin muncul
- Apa fungsi file ini dan apa akibatnya jika file ini tidak dipanggil?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/includes/csrf.php`
**Ukuran:** 45 baris. **Peran:** menyediakan generator, field, dan verifier CSRF.

### Kode asli (line-numbered)
```text
0001  <?php
0002  /**
0003   * CSRF protection helpers.
0004   */
0005  
0006  if (session_status() !== PHP_SESSION_ACTIVE) {
0007      session_start();
0008  }
0009  
0010  function csrf_token(): string
0011  {
0012      if (empty($_SESSION['csrf_token'])) {
0013          $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
0014      }
0015  
0016      return $_SESSION['csrf_token'];
0017  }
0018  
0019  function csrf_field(): string
0020  {
0021      return '<input type="hidden" name="csrf_token" value="' .
0022          htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') .
0023          '">';
0024  }
0025  
0026  function csrf_verify(): void
0027  {
0028      if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
0029          return;
0030      }
0031  
0032      $sessionToken = $_SESSION['csrf_token'] ?? '';
0033      $postedToken = $_POST['csrf_token'] ?? '';
0034  
0035      if (
0036          !is_string($sessionToken) ||
0037          !is_string($postedToken) ||
0038          $sessionToken === '' ||
0039          $postedToken === '' ||
0040          !hash_equals($sessionToken, $postedToken)
0041      ) {
0042          http_response_code(403);
0043          exit('CSRF token tidak valid.');
0044      }
0045  }
```
### Konsep yang harus bisa dijelaskan
CSRF verification, HTML escaping / XSS mitigation, constant-time token comparison.
### Pertanyaan dosen yang mungkin muncul
- Kenapa endpoint POST perlu `csrf_verify()`?
- Bagian mana yang mencegah XSS?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/includes/helpers.php`
**Ukuran:** 8 baris. **Peran:** bagian aplikasi yang menangani halaman/CRUD terkait.

### Kode asli (line-numbered)
```text
0001  <?php
0002  /**
0003   * Escape output safely for HTML.
0004   */
0005  function e($value): string
0006  {
0007      return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
0008  }
```
### Konsep yang harus bisa dijelaskan
HTML escaping / XSS mitigation.
### Pertanyaan dosen yang mungkin muncul
- Bagian mana yang mencegah XSS?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/auth/register.php`
**Ukuran:** 169 baris. **Peran:** form/proses registrasi dan hashing password.

### Kode asli (line-numbered)
```text
0001  <?php
0002  
0003  if (session_status() === PHP_SESSION_NONE) {
0004      session_start();
0005  }
0006  
0007  if (isset($_SESSION['user_id'])) {
0008      header("Location: /Jobsheet12/");
0009      exit;
0010  }
0011  
0012  $page_title = "Register";
0013  
0014  require __DIR__ . "/../config/database.php";
0015  require __DIR__ . "/../includes/csrf.php";
0016  
0017  $errors = [];
0018  
0019  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
0020  
0021      csrf_verify();
0022  
0023      $nama = trim($_POST['nama'] ?? '');
0024      $username = trim($_POST['username'] ?? '');
0025      $password = $_POST['password'] ?? '';
0026      $konfirmasi = $_POST['konfirmasi_password'] ?? '';
0027  
0028      if ($nama === '') {
0029          $errors[] = "Nama wajib diisi.";
0030      }
0031  
0032      if ($username === '') {
0033          $errors[] = "Username wajib diisi.";
0034      }
0035  
0036      if ($password === '') {
0037          $errors[] = "Password wajib diisi.";
0038      } elseif (strlen($password) < 6) {
0039          $errors[] = "Password minimal 6 karakter.";
0040      }
0041  
0042      if ($password !== $konfirmasi) {
0043          $errors[] = "Konfirmasi password tidak sama.";
0044      }
0045  
0046      if (!$errors) {
0047  
0048          $cek = $pdo->prepare("
0049              SELECT id
0050              FROM users
0051              WHERE username = :username
0052              LIMIT 1
0053          ");
0054  
0055          $cek->execute([
0056              ':username' => $username
0057          ]);
0058  
0059          if ($cek->fetch()) {
0060              $errors[] = "Username sudah digunakan.";
0061          }
0062      }
0063  
0064      if (!$errors) {
0065  
0066          $stmt = $pdo->prepare("
0067              INSERT INTO users (
0068                  nama,
0069                  username,
0070                  password,
0071                  role
0072              )
0073              VALUES (
0074                  :nama,
0075                  :username,
0076                  :password,
0077                  'petugas'
0078              )
0079          ");
0080  
0081          $stmt->execute([
0082              ':nama' => $nama,
0083              ':username' => $username,
0084              ':password' => password_hash($password, PASSWORD_DEFAULT)
0085          ]);
0086  
0087          header("Location: login.php?pesan=daftar");
0088          exit;
0089      }
0090  }
0091  
0092  require __DIR__ . "/../layout/header.php";
0093  ?>
0094  
0095  <section style="max-width: 560px; margin: 0 auto;">
0096  
0097      <h2>Register</h2>
0098  
0099      <?php if ($errors): ?>
0100  
0101          <div class="alert alert-error">
0102  
0103              <?php foreach ($errors as $error): ?>
0104                  <p><?= htmlspecialchars($error); ?></p>
0105              <?php endforeach; ?>
0106  
0107          </div>
0108  
0109      <?php endif; ?>
0110  
0111      <form method="POST">
0112  
0113          <?= csrf_field(); ?>
0114  
0115          <div>
0116              <label for="nama">Nama</label>
0117              <input
0118                  type="text"
0119                  id="nama"
0120                  name="nama"
0121                  value="<?= htmlspecialchars($_POST['nama'] ?? ''); ?>"
0122                  required>
0123          </div>
0124  
0125          <div>
0126              <label for="username">Username</label>
0127              <input
0128                  type="text"
0129                  id="username"
0130                  name="username"
0131                  value="<?= htmlspecialchars($_POST['username'] ?? ''); ?>"
0132                  required>
0133          </div>
0134  
0135          <div>
0136              <label for="password">Password</label>
0137              <input
0138                  type="password"
0139                  id="password"
0140                  name="password"
0141                  required
0142                  minlength="6">
0143          </div>
0144  
0145          <div>
0146              <label for="konfirmasi_password">Konfirmasi Password</label>
0147              <input
0148                  type="password"
0149                  id="konfirmasi_password"
0150                  name="konfirmasi_password"
0151                  required
0152                  minlength="6">
0153          </div>
0154          <button type="submit" class="btn">
0155              Register
0156          </button>
0157  
0158      </form>
0159  
0160      <p style="margin-top: 18px;">
0161          Sudah punya akun?
0162          <a href="login.php" style="color: var(--burgundy); font-weight: 600;">
0163              Login
0164          </a>
0165      </p>
0166  
0167  </section>
0168  
0169  <?php require __DIR__ . "/../layout/footer.php"; ?>
```
### Konsep yang harus bisa dijelaskan
CSRF verification, HTML escaping / XSS mitigation, pagination, parameterized execution, password hashing.
### Pertanyaan dosen yang mungkin muncul
- Kenapa menggunakan `prepare()` dan bukan string SQL biasa?
- Kenapa password di-hash, bukan disimpan plaintext?
- Kenapa endpoint POST perlu `csrf_verify()`?
- Bagian mana yang mencegah XSS?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/auth/process_login.php`
**Ukuran:** 46 baris. **Peran:** memvalidasi login, mengambil user, memverifikasi hash, meregenerasi session ID, lalu menyimpan session.

### Kode asli (line-numbered)
```text
0001  <?php
0002  
0003  if (session_status() === PHP_SESSION_NONE) {
0004      session_start();
0005  }
0006  
0007  require __DIR__ . "/../includes/csrf.php";
0008  require __DIR__ . "/../config/database.php";
0009  
0010  csrf_verify();
0011  
0012  $username = trim($_POST['username'] ?? '');
0013  $password = $_POST['password'] ?? '';
0014  
0015  if ($username === '' || $password === '') {
0016      header("Location: login.php?pesan=gagal");
0017      exit;
0018  }
0019  
0020  $stmt = $pdo->prepare("
0021      SELECT id, nama, username, password, role
0022      FROM users
0023      WHERE username = :username
0024      LIMIT 1
0025  ");
0026  
0027  $stmt->execute([
0028      ':username' => $username
0029  ]);
0030  
0031  $user = $stmt->fetch();
0032  
0033  if (!$user || !password_verify($password, $user['password'])) {
0034      header("Location: login.php?pesan=gagal");
0035      exit;
0036  }
0037  
0038  session_regenerate_id(true);
0039  
0040  $_SESSION['user_id'] = $user['id'];
0041  $_SESSION['user_name'] = $user['nama'];
0042  $_SESSION['username'] = $user['username'];
0043  $_SESSION['role'] = $user['role'];
0044  
0045  header("Location: /Jobsheet12/");
0046  exit;
```
### Konsep yang harus bisa dijelaskan
CSRF verification, pagination, parameterized execution, password verification, session fixation mitigation.
### Pertanyaan dosen yang mungkin muncul
- Kenapa menggunakan `prepare()` dan bukan string SQL biasa?
- Bagaimana `password_verify()` bekerja?
- Kenapa endpoint POST perlu `csrf_verify()`?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/auth/logout.php`
**Ukuran:** 27 baris. **Peran:** bagian aplikasi yang menangani halaman/CRUD terkait.

### Kode asli (line-numbered)
```text
0001  <?php
0002  
0003  if (session_status() === PHP_SESSION_NONE) {
0004      session_start();
0005  }
0006  
0007  $_SESSION = [];
0008  
0009  if (ini_get('session.use_cookies')) {
0010  
0011      $params = session_get_cookie_params();
0012  
0013      setcookie(
0014          session_name(),
0015          '',
0016          time() - 42000,
0017          $params['path'],
0018          $params['domain'],
0019          $params['secure'],
0020          $params['httponly']
0021      );
0022  }
0023  
0024  session_destroy();
0025  
0026  header("Location: /Jobsheet12/auth/login.php?pesan=logout");
0027  exit;
```
### Pertanyaan dosen yang mungkin muncul
- Apa fungsi file ini dan apa akibatnya jika file ini tidak dipanggil?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/master/menu/index.php`
**Ukuran:** 333 baris. **Peran:** bagian aplikasi yang menangani halaman/CRUD terkait.

### Kode asli (line-numbered)
```text
0001  <?php
0002  
0003  $page_title = "Menu";
0004  
0005  require __DIR__ . "/../../includes/csrf.php";
0006  require __DIR__ . "/../../config/database.php";
0007  
0008  $keyword = trim($_GET['keyword'] ?? '');
0009  $page = max(1, (int) ($_GET['page'] ?? 1));
0010  $perPage = 5;
0011  
0012  $whereSql = '';
0013  $params = [];
0014  
0015  if ($keyword !== '') {
0016      $whereSql = "WHERE (menu.kode_menu ILIKE :keyword OR menu.nama_menu ILIKE :keyword OR kategori.nama_kategori ILIKE :keyword OR menu.status ILIKE :keyword)";
0017      $params[':keyword'] = '%' . $keyword . '%';
0018  }
0019  
0020  $countStmt = $pdo->prepare("
0021      SELECT COUNT(*)
0022      FROM menu INNER JOIN kategori ON menu.kategori_id = kategori.id
0023      $whereSql
0024  ");
0025  $countStmt->execute($params);
0026  $totalData = (int) $countStmt->fetchColumn();
0027  $totalPages = max(1, (int) ceil($totalData / $perPage));
0028  $page = min($page, $totalPages);
0029  $offset = ($page - 1) * $perPage;
0030  
0031  $query = $pdo->prepare("
0032      SELECT
0033          menu.id,
0034          menu.kode_menu,
0035          menu.nama_menu,
0036          kategori.nama_kategori,
0037          menu.harga,
0038          menu.stok,
0039          menu.status
0040      FROM menu INNER JOIN kategori ON menu.kategori_id = kategori.id
0041      $whereSql
0042      ORDER BY menu.id ASC
0043      LIMIT :limit OFFSET :offset
0044  ");
0045  
0046  foreach ($params as $name => $value) {
0047      $query->bindValue($name, $value, PDO::PARAM_STR);
0048  }
0049  $query->bindValue(':limit', $perPage, PDO::PARAM_INT);
0050  $query->bindValue(':offset', $offset, PDO::PARAM_INT);
0051  $query->execute();
0052  
0053  $menu = $query->fetchAll(PDO::FETCH_ASSOC);
0054  
0055  $pesan = $_GET['pesan'] ?? '';
0056  
0057  ?>
0058  
0059  <?php require __DIR__ . "/../../layout/header.php"; ?>
0060  
0061  
0062  <section>
0063  
0064      <div style="
0065          display: flex;
0066          justify-content: space-between;
0067          align-items: center;
0068          gap: 15px;
0069          flex-wrap: wrap;
0070      ">
0071  
0072          <div>
0073  
0074              <h2>
0075                  Data Menu
0076              </h2>
0077  
0078              <p>
0079                  Kelola daftar menu Cafe_Najwa.
0080              </p>
0081  
0082          </div>
0083  
0084  
0085          <a
0086              href="form.php"
0087              class="btn">
0088              + Tambah Menu
0089          </a>
0090  
0091      </div>
0092  
0093  </section>
0094  
0095  
0096  <?php if ($pesan === 'tambah'): ?>
0097  
0098      <section>
0099  
0100          <p>
0101              ✅ Menu berhasil ditambahkan.
0102          </p>
0103  
0104      </section>
0105  
0106  <?php elseif ($pesan === 'edit'): ?>
0107  
0108      <section>
0109  
0110          <p>
0111              ✅ Data menu berhasil diperbarui.
0112          </p>
0113  
0114      </section>
0115  
0116  <?php elseif ($pesan === 'hapus'): ?>
0117  
0118      <section>
0119  
0120          <p>
0121              ✅ Menu berhasil dihapus.
0122          </p>
0123  
0124      </section>
0125  
0126  <?php elseif ($pesan === 'gagal'): ?>
0127  
0128      <section>
0129  
0130          <p>
0131              ❌ Proses gagal dilakukan.
0132          </p>
0133  
0134      </section>
0135  
0136  <?php endif; ?>
0137  
0138  
0139  <section>
0140  
0141  
0142      <form method="GET" class="search-form" style="margin-bottom: 15px;">
0143  
0144          <input
0145              type="text"
0146              name="keyword"
0147              value="<?= htmlspecialchars($keyword); ?>"
0148              placeholder="Cari kode, nama, kategori, atau status..."
0149          >
0150  
0151          <button type="submit" class="btn">
0152              Cari
0153          </button>
0154  
0155          <?php if ($keyword !== ''): ?>
0156              <a href="index.php" class="btn">Reset</a>
0157          <?php endif; ?>
0158  
0159      </form>
0160  
0161  
0162      <div class="table-responsive">
0163  
0164          <table id="tabelMenu">
0165  
0166              <thead>
0167  
0168                  <tr>
0169  
0170                      <th>No</th>
0171  
0172                      <th>Kode Menu</th>
0173  
0174                      <th>Nama Menu</th>
0175  
0176                      <th>Kategori</th>
0177  
0178                      <th>Harga</th>
0179  
0180                      <th>Stok</th>
0181  
0182                      <th>Status</th>
0183  
0184                      <th>Aksi</th>
0185  
0186                  </tr>
0187  
0188              </thead>
0189  
0190  
0191              <tbody>
0192  
0193                  <?php if (count($menu) > 0): ?>
0194  
0195  
0196                      <?php foreach ($menu as $index => $data): ?>
0197  
0198                          <tr>
0199  
0200                              <td>
0201                                  <?= $offset + $index + 1; ?>
0202                              </td>
0203  
0204  
0205                              <td>
0206                                  <?= htmlspecialchars(
0207                                      $data['kode_menu']
0208                                  ); ?>
0209                              </td>
0210  
0211  
0212                              <td>
0213                                  <?= htmlspecialchars(
0214                                      $data['nama_menu']
0215                                  ); ?>
0216                              </td>
0217  
0218  
0219                              <td>
0220                                  <?= htmlspecialchars(
0221                                      $data['nama_kategori']
0222                                  ); ?>
0223                              </td>
0224  
0225  
0226                              <td>
0227                                  Rp
0228                                  <?= number_format(
0229                                      $data['harga'],
0230                                      0,
0231                                      ',',
0232                                      '.'
0233                                  ); ?>
0234                              </td>
0235  
0236  
0237                              <td>
0238                                  <?= htmlspecialchars(
0239                                      $data['stok']
0240                                  ); ?>
0241                              </td>
0242  
0243  
0244                              <td>
0245                                  <?= htmlspecialchars(
0246                                      $data['status']
0247                                  ); ?>
0248                              </td>
0249  
0250  
0251                              <td>
0252  
0253                                  <div class="actions">
0254  
0255                                      <a
0256                                          href="form.php?id=<?= $data['id']; ?>"
0257                                          class="btn">
0258                                          Edit
0259                                      </a>
0260  
0261  
0262                                      <form action="hapus.php" method="POST" class="form-hapus">
0263                                          <?= csrf_field(); ?>
0264                                          <input type="hidden" name="id" value="<?= $data['id']; ?>">
0265                                          <button type="submit" class="btn btn-hapus">
0266                                              Hapus
0267                                          </button>
0268                                      </form>
0269  
0270                                  </div>
0271  
0272                              </td>
0273  
0274                          </tr>
0275  
0276                      <?php endforeach; ?>
0277  
0278  
0279                  <?php else: ?>
0280  
0281  
0282                      <tr>
0283  
0284                          <td colspan="8">
0285                              Belum ada data menu.
0286                          </td>
0287  
0288                      </tr>
0289  
0290  
0291                  <?php endif; ?>
0292  
0293              </tbody>
0294  
0295          </table>
0296  
0297      </div>
0298  
0299  </section>
0300  
0301  
0302  <div class="pagination-wrapper">
0303  
0304      <?php if ($totalPages > 1): ?>
0305  
0306          <div class="pagination">
0307  
0308              <?php if ($page > 1): ?>
0309                  <a href="?page=<?= $page - 1; ?>&keyword=<?= urlencode($keyword); ?>">
0310                      ← Sebelumnya
0311                  </a>
0312              <?php endif; ?>
0313  
0314              <?php for ($i = 1; $i <= $totalPages; $i++): ?>
0315                  <a href="?page=<?= $i; ?>&keyword=<?= urlencode($keyword); ?>" class="<?= $i === $page ? 'active' : ''; ?>">
0316                      <?= $i; ?>
0317                  </a>
0318              <?php endfor; ?>
0319  
0320              <?php if ($page < $totalPages): ?>
0321                  <a href="?page=<?= $page + 1; ?>&keyword=<?= urlencode($keyword); ?>">
0322                      Berikutnya →
0323                  </a>
0324              <?php endif; ?>
0325  
0326          </div>
0327  
0328      <?php endif; ?>
0329  
0330  </div>
0331  
0332  
0333  <?php require __DIR__ . "/../../layout/footer.php"; ?>
```
### Konsep yang harus bisa dijelaskan
HTML escaping / XSS mitigation, PostgreSQL case-insensitive search, multi-row fetch, pagination, parameterized execution, relational join, single-value fetch.
### Pertanyaan dosen yang mungkin muncul
- Kenapa menggunakan `prepare()` dan bukan string SQL biasa?
- Bagian mana yang mencegah XSS?
- Kenapa memakai `ILIKE`?
- Bagaimana rumus pagination dan dari mana `LIMIT/OFFSET` berasal?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/master/menu/proses.php`
**Ukuran:** 297 baris. **Peran:** bagian aplikasi yang menangani halaman/CRUD terkait.

### Kode asli (line-numbered)
```text
0001  <?php
0002  
0003  require_once __DIR__ . "/../../includes/auth.php";
0004  require __DIR__ . "/../../includes/csrf.php";
0005  
0006  
0007  require __DIR__ . "/../../config/database.php";
0008  
0009  csrf_verify();
0010  
0011  $aksi = $_POST['aksi'] ?? '';
0012  
0013  
0014  /*
0015  |--------------------------------------------------------------------------
0016  | TAMBAH MENU
0017  |--------------------------------------------------------------------------
0018  */
0019  
0020  if ($aksi === 'tambah') {
0021  
0022      $kode_menu = trim(
0023          $_POST['kode_menu'] ?? ''
0024      );
0025  
0026      $nama_menu = trim(
0027          $_POST['nama_menu'] ?? ''
0028      );
0029  
0030      $kategori_id = $_POST['kategori_id'] ?? '';
0031  
0032      $harga = $_POST['harga'] ?? '';
0033  
0034      $stok = $_POST['stok'] ?? '';
0035  
0036      $status = $_POST['status'] ?? 'Tersedia';
0037  
0038  
0039      if (
0040          $kode_menu === '' ||
0041          $nama_menu === '' ||
0042          $kategori_id === '' ||
0043          $harga === '' ||
0044          $stok === ''
0045      ) {
0046  
0047          header("Location: form.php");
0048          exit;
0049  
0050      }
0051  
0052  
0053      if (
0054          !is_numeric($harga) ||
0055          (float)$harga < 0
0056      ) {
0057  
0058          header("Location: form.php");
0059          exit;
0060  
0061      }
0062  
0063  
0064      if (
0065          !is_numeric($stok) ||
0066          (int)$stok < 0
0067      ) {
0068  
0069          header("Location: form.php");
0070          exit;
0071  
0072      }
0073  
0074  
0075      $status_valid = [
0076          'Tersedia',
0077          'Tidak Tersedia'
0078      ];
0079  
0080  
0081      if (!in_array(
0082          $status,
0083          $status_valid,
0084          true
0085      )) {
0086  
0087          header("Location: form.php");
0088          exit;
0089  
0090      }
0091  
0092  
0093      try {
0094  
0095          $stmt = $pdo->prepare("
0096              INSERT INTO menu (
0097                  kode_menu,
0098                  nama_menu,
0099                  kategori_id,
0100                  harga,
0101                  stok,
0102                  status
0103              )
0104              VALUES (
0105                  :kode_menu,
0106                  :nama_menu,
0107                  :kategori_id,
0108                  :harga,
0109                  :stok,
0110                  :status
0111              )
0112          ");
0113  
0114  
0115          $stmt->execute([
0116  
0117              ':kode_menu' => $kode_menu,
0118  
0119              ':nama_menu' => $nama_menu,
0120  
0121              ':kategori_id' => (int)$kategori_id,
0122  
0123              ':harga' => (float)$harga,
0124  
0125              ':stok' => (int)$stok,
0126  
0127              ':status' => $status
0128  
0129          ]);
0130  
0131  
0132          header(
0133              "Location: index.php?pesan=tambah"
0134          );
0135  
0136          exit;
0137  
0138  
0139      } catch (PDOException $e) {
0140  
0141          header(
0142              "Location: index.php?pesan=gagal"
0143          );
0144  
0145          exit;
0146  
0147      }
0148  }
0149  
0150  
0151  /*
0152  |--------------------------------------------------------------------------
0153  | EDIT MENU
0154  |--------------------------------------------------------------------------
0155  */
0156  
0157  if ($aksi === 'edit') {
0158  
0159      $id = $_POST['id'] ?? '';
0160  
0161      $kode_menu = trim(
0162          $_POST['kode_menu'] ?? ''
0163      );
0164  
0165      $nama_menu = trim(
0166          $_POST['nama_menu'] ?? ''
0167      );
0168  
0169      $kategori_id = $_POST['kategori_id'] ?? '';
0170  
0171      $harga = $_POST['harga'] ?? '';
0172  
0173      $stok = $_POST['stok'] ?? '';
0174  
0175      $status = $_POST['status'] ?? 'Tersedia';
0176  
0177  
0178      if (
0179          $id === '' ||
0180          $kode_menu === '' ||
0181          $nama_menu === '' ||
0182          $kategori_id === '' ||
0183          $harga === '' ||
0184          $stok === ''
0185      ) {
0186  
0187          header(
0188              "Location: index.php?pesan=gagal"
0189          );
0190  
0191          exit;
0192  
0193      }
0194  
0195  
0196      if (
0197          !is_numeric($harga) ||
0198          (float)$harga < 0
0199      ) {
0200  
0201          header(
0202              "Location: index.php?pesan=gagal"
0203          );
0204  
0205          exit;
0206  
0207      }
0208  
0209  
0210      if (
0211          !is_numeric($stok) ||
0212          (int)$stok < 0
0213      ) {
0214  
0215          header(
0216              "Location: index.php?pesan=gagal"
0217          );
0218  
0219          exit;
0220  
0221      }
0222  
0223  
0224      $status_valid = [
0225          'Tersedia',
0226          'Tidak Tersedia'
0227      ];
0228  
0229  
0230      if (!in_array(
0231          $status,
0232          $status_valid,
0233          true
0234      )) {
0235  
0236          header(
0237              "Location: index.php?pesan=gagal"
0238          );
0239  
0240          exit;
0241  
0242      }
0243  
0244  
0245      try {
0246  
0247          $stmt = $pdo->prepare("
0248              UPDATE menu
0249  
0250              SET
0251                  kode_menu = :kode_menu,
0252                  nama_menu = :nama_menu,
0253                  kategori_id = :kategori_id,
0254                  harga = :harga,
0255                  stok = :stok,
0256                  status = :status
0257  
0258              WHERE id = :id
0259          ");
0260  
0261  
0262          $stmt->execute([
0263  
0264              ':kode_menu' => $kode_menu,
0265  
0266              ':nama_menu' => $nama_menu,
0267  
0268              ':kategori_id' => (int)$kategori_id,
0269  
0270              ':harga' => (float)$harga,
0271  
0272              ':stok' => (int)$stok,
0273  
0274              ':status' => $status,
0275  
0276              ':id' => $id
0277  
0278          ]);
0279  
0280  
0281          header(
0282              "Location: index.php?pesan=edit"
0283          );
0284  
0285          exit;
0286  
0287  
0288      } catch (PDOException $e) {
0289  
0290          header(
0291              "Location: index.php?pesan=gagal"
0292          );
0293  
0294          exit;
0295  
0296      }
0297  }
```
### Konsep yang harus bisa dijelaskan
CSRF verification, parameterized execution.
### Pertanyaan dosen yang mungkin muncul
- Kenapa menggunakan `prepare()` dan bukan string SQL biasa?
- Kenapa endpoint POST perlu `csrf_verify()`?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/master/menu/hapus.php`
**Ukuran:** 32 baris. **Peran:** bagian aplikasi yang menangani halaman/CRUD terkait.

### Kode asli (line-numbered)
```text
0001  <?php
0002  
0003  require_once __DIR__ . "/../../includes/auth.php";
0004  require __DIR__ . "/../../includes/csrf.php";
0005  
0006  
0007  require __DIR__ . "/../../config/database.php";
0008  
0009  csrf_verify();
0010  
0011  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
0012      header("Location: index.php");
0013      exit;
0014  }
0015  
0016  $id = $_POST['id'] ?? '';
0017  
0018  if ($id === '') {
0019      header("Location: index.php?pesan=gagal");
0020      exit;
0021  }
0022  
0023  try {
0024      $stmt = $pdo->prepare("DELETE FROM menu WHERE id = :id");
0025      $stmt->execute([':id' => $id]);
0026  
0027      header("Location: index.php?pesan=hapus");
0028      exit;
0029  } catch (PDOException $e) {
0030      header("Location: index.php?pesan=gagal");
0031      exit;
0032  }
```
### Konsep yang harus bisa dijelaskan
CSRF verification, parameterized execution.
### Pertanyaan dosen yang mungkin muncul
- Kenapa menggunakan `prepare()` dan bukan string SQL biasa?
- Kenapa endpoint POST perlu `csrf_verify()`?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/transaksi/pesanan/index.php`
**Ukuran:** 347 baris. **Peran:** bagian aplikasi yang menangani halaman/CRUD terkait.

### Kode asli (line-numbered)
```text
0001  <?php
0002  
0003  require_once __DIR__ . "/../../includes/auth.php";
0004  require __DIR__ . "/../../includes/csrf.php";
0005  
0006  
0007  $page_title = "Pesanan";
0008  
0009  require __DIR__ . "/../../config/database.php";
0010  
0011  $keyword = trim($_GET['keyword'] ?? '');
0012  $page = max(1, (int) ($_GET['page'] ?? 1));
0013  $perPage = 5;
0014  
0015  $whereSql = '';
0016  $params = [];
0017  
0018  if ($keyword !== '') {
0019      $whereSql = "WHERE (pesanan.kode_pesanan ILIKE :keyword OR pelanggan.nama ILIKE :keyword OR meja.nomor_meja ILIKE :keyword OR pesanan.status ILIKE :keyword)";
0020      $params[':keyword'] = '%' . $keyword . '%';
0021  }
0022  
0023  $countStmt = $pdo->prepare("
0024      SELECT COUNT(*)
0025      FROM pesanan LEFT JOIN pelanggan ON pesanan.pelanggan_id = pelanggan.id LEFT JOIN meja ON pesanan.meja_id = meja.id
0026      $whereSql
0027  ");
0028  $countStmt->execute($params);
0029  $totalData = (int) $countStmt->fetchColumn();
0030  $totalPages = max(1, (int) ceil($totalData / $perPage));
0031  $page = min($page, $totalPages);
0032  $offset = ($page - 1) * $perPage;
0033  
0034  $query = $pdo->prepare("
0035      SELECT
0036          pesanan.id,
0037          pesanan.kode_pesanan,
0038          pelanggan.nama AS nama_pelanggan,
0039          meja.nomor_meja,
0040          pesanan.tanggal_pesanan,
0041          pesanan.status,
0042          pesanan.total
0043      FROM pesanan LEFT JOIN pelanggan ON pesanan.pelanggan_id = pelanggan.id LEFT JOIN meja ON pesanan.meja_id = meja.id
0044      $whereSql
0045      ORDER BY pesanan.id DESC
0046      LIMIT :limit OFFSET :offset
0047  ");
0048  
0049  foreach ($params as $name => $value) {
0050      $query->bindValue($name, $value, PDO::PARAM_STR);
0051  }
0052  $query->bindValue(':limit', $perPage, PDO::PARAM_INT);
0053  $query->bindValue(':offset', $offset, PDO::PARAM_INT);
0054  $query->execute();
0055  
0056  $pesanan = $query->fetchAll(PDO::FETCH_ASSOC);
0057  
0058  $pesan = $_GET['pesan'] ?? '';
0059  
0060  ?>
0061  
0062  <?php require __DIR__ . "/../../layout/header.php"; ?>
0063  
0064  
0065  <section>
0066  
0067      <div style="
0068          display: flex;
0069          justify-content: space-between;
0070          align-items: center;
0071          gap: 15px;
0072          flex-wrap: wrap;
0073      ">
0074  
0075          <div>
0076  
0077              <h2>
0078                  Data Pesanan
0079              </h2>
0080  
0081              <p>
0082                  Kelola transaksi pesanan Cafe_Najwa.
0083              </p>
0084  
0085          </div>
0086  
0087  
0088          <a
0089              href="form.php"
0090              class="btn">
0091              + Tambah Pesanan
0092          </a>
0093  
0094      </div>
0095  
0096  </section>
0097  
0098  
0099  <?php if ($pesan === 'tambah'): ?>
0100  
0101      <section>
0102          <p>
0103              ✅ Pesanan berhasil ditambahkan.
0104          </p>
0105      </section>
0106  
0107  <?php elseif ($pesan === 'edit'): ?>
0108  
0109      <section>
0110          <p>
0111              ✅ Pesanan berhasil diperbarui.
0112          </p>
0113      </section>
0114  
0115  <?php elseif ($pesan === 'hapus'): ?>
0116  
0117      <section>
0118          <p>
0119              ✅ Pesanan berhasil dihapus.
0120          </p>
0121      </section>
0122  
0123  <?php elseif ($pesan === 'meja_kosong'): ?>
0124  
0125      <section>
0126          <p>
0127              ✅ Meja berhasil dikosongkan.
0128          </p>
0129      </section>
0130  
0131  <?php elseif ($pesan === 'gagal'): ?>
0132  
0133      <section>
0134          <p>
0135              ❌ Proses gagal dilakukan.
0136          </p>
0137      </section>
0138  
0139  <?php endif; ?>
0140  
0141  
0142  <section>
0143  
0144      <form method="GET" class="search-form" style="margin-bottom: 15px;">
0145  
0146          <input
0147              type="text"
0148              name="keyword"
0149              value="<?= htmlspecialchars($keyword); ?>"
0150              placeholder="Cari kode, pelanggan, meja, atau status..."
0151          >
0152  
0153          <button type="submit" class="btn">
0154              Cari
0155          </button>
0156  
0157          <?php if ($keyword !== ''): ?>
0158              <a href="index.php" class="btn">Reset</a>
0159          <?php endif; ?>
0160  
0161      </form>
0162  
0163  
0164      <div class="table-responsive">
0165  
0166          <table id="tabelPesanan">
0167  
0168              <thead>
0169  
0170                  <tr>
0171  
0172                      <th>No</th>
0173  
0174                      <th>Kode Pesanan</th>
0175  
0176                      <th>Pelanggan</th>
0177  
0178                      <th>Meja</th>
0179  
0180                      <th>Tanggal</th>
0181  
0182                      <th>Status</th>
0183  
0184                      <th>Total</th>
0185  
0186                      <th>Aksi</th>
0187  
0188                  </tr>
0189  
0190              </thead>
0191  
0192  
0193              <tbody>
0194  
0195                  <?php if (count($pesanan) > 0): ?>
0196  
0197  
0198                      <?php foreach ($pesanan as $index => $data): ?>
0199  
0200                          <tr>
0201  
0202                              <td>
0203                                  <?= $offset + $index + 1; ?>
0204                              </td>
0205  
0206  
0207                              <td>
0208                                  <?= htmlspecialchars(
0209                                      $data['kode_pesanan']
0210                                  ); ?>
0211                              </td>
0212  
0213  
0214                              <td>
0215                                  <?= htmlspecialchars(
0216                                      $data['nama_pelanggan'] ?? '-'
0217                                  ); ?>
0218                              </td>
0219  
0220  
0221                              <td>
0222                                  <?= htmlspecialchars(
0223                                      $data['nomor_meja'] ?? '-'
0224                                  ); ?>
0225                              </td>
0226  
0227  
0228                              <td>
0229                                  <?= date(
0230                                      'd-m-Y H:i',
0231                                      strtotime(
0232                                          $data['tanggal_pesanan']
0233                                      )
0234                                  ); ?>
0235                              </td>
0236  
0237  
0238                              <td>
0239                                  <?= htmlspecialchars(
0240                                      $data['status']
0241                                  ); ?>
0242                              </td>
0243  
0244  
0245                              <td>
0246                                  Rp
0247                                  <?= number_format(
0248                                      $data['total'],
0249                                      0,
0250                                      ',',
0251                                      '.'
0252                                  ); ?>
0253                              </td>
0254  
0255  
0256                              <td>
0257  
0258                                  <div class="actions">
0259  
0260                                      <a
0261                                          href="form.php?id=<?= $data['id']; ?>"
0262                                          class="btn">
0263                                          Detail
0264                                      </a>
0265  
0266                                      <?php if ($data['status'] === 'Selesai'): ?>
0267                                          <form action="kosongkan_meja.php" method="POST">
0268                                              <?= csrf_field(); ?>
0269                                              <input type="hidden" name="id" value="<?= $data['id']; ?>">
0270                                              <button type="submit" class="btn">
0271                                                  Kosongkan Meja
0272                                              </button>
0273                                          </form>
0274                                      <?php endif; ?>
0275  
0276                                      <form action="hapus.php" method="POST" class="form-hapus">
0277                                          <?= csrf_field(); ?>
0278                                          <input type="hidden" name="id" value="<?= $data['id']; ?>">
0279                                          <button type="submit" class="btn btn-hapus">
0280                                              Hapus
0281                                          </button>
0282                                      </form>
0283  
0284                                  </div>
0285  
0286                              </td>
0287  
0288                          </tr>
0289  
0290                      <?php endforeach; ?>
0291  
0292  
0293                  <?php else: ?>
0294  
0295  
0296                      <tr>
0297  
0298                          <td colspan="8">
0299                              Belum ada data pesanan.
0300                          </td>
0301  
0302                      </tr>
0303  
0304  
0305                  <?php endif; ?>
0306  
0307              </tbody>
0308  
0309          </table>
0310  
0311      </div>
0312  
0313  </section>
0314  
0315  
0316  <div class="pagination-wrapper">
0317  
0318      <?php if ($totalPages > 1): ?>
0319  
0320          <div class="pagination">
0321  
0322              <?php if ($page > 1): ?>
0323                  <a href="?page=<?= $page - 1; ?>&keyword=<?= urlencode($keyword); ?>">
0324                      ← Sebelumnya
0325                  </a>
0326              <?php endif; ?>
0327  
0328              <?php for ($i = 1; $i <= $totalPages; $i++): ?>
0329                  <a href="?page=<?= $i; ?>&keyword=<?= urlencode($keyword); ?>" class="<?= $i === $page ? 'active' : ''; ?>">
0330                      <?= $i; ?>
0331                  </a>
0332              <?php endfor; ?>
0333  
0334              <?php if ($page < $totalPages): ?>
0335                  <a href="?page=<?= $page + 1; ?>&keyword=<?= urlencode($keyword); ?>">
0336                      Berikutnya →
0337                  </a>
0338              <?php endif; ?>
0339  
0340          </div>
0341  
0342      <?php endif; ?>
0343  
0344  </div>
0345  
0346  
0347  <?php require __DIR__ . "/../../layout/footer.php"; ?>
```
### Konsep yang harus bisa dijelaskan
HTML escaping / XSS mitigation, PostgreSQL case-insensitive search, multi-row fetch, pagination, parameterized execution, relational join, single-value fetch.
### Pertanyaan dosen yang mungkin muncul
- Kenapa menggunakan `prepare()` dan bukan string SQL biasa?
- Bagian mana yang mencegah XSS?
- Kenapa memakai `ILIKE`?
- Bagaimana rumus pagination dan dari mana `LIMIT/OFFSET` berasal?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/transaksi/pesanan/form.php`
**Ukuran:** 805 baris. **Peran:** bagian aplikasi yang menangani halaman/CRUD terkait.

### Kode asli (line-numbered)
```text
0001  <?php
0002  
0003  require_once __DIR__ . "/../../includes/auth.php";
0004  require __DIR__ . "/../../includes/csrf.php";
0005  
0006  
0007  require_once __DIR__ . '/../../config/database.php';
0008  
0009  $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
0010  
0011  $aksi = $id > 0 ? 'edit' : 'tambah';
0012  
0013  $kode_pesanan = '';
0014  $tanggal_pesanan = date('Y-m-d\TH:i');
0015  $pelanggan_id = '';
0016  $meja_id = '';
0017  $status = 'Proses';
0018  
0019  $detail_lama = [];
0020  
0021  /* =========================================================
0022     DATA MASTER
0023  ========================================================= */
0024  
0025  $pelanggan = $pdo->query("
0026      SELECT id, kode_pelanggan, nama
0027      FROM pelanggan
0028      ORDER BY nama ASC
0029  ")->fetchAll(PDO::FETCH_ASSOC);
0030  
0031  $meja = $pdo->query("
0032      SELECT id, nomor_meja, kapasitas, status
0033      FROM meja
0034      ORDER BY nomor_meja ASC
0035  ")->fetchAll(PDO::FETCH_ASSOC);
0036  
0037  $menu = $pdo->query("
0038      SELECT
0039          menu.id,
0040          menu.kode_menu,
0041          menu.nama_menu,
0042          menu.harga,
0043          menu.stok,
0044          menu.status,
0045          kategori.nama_kategori
0046      FROM menu
0047      INNER JOIN kategori
0048          ON menu.kategori_id = kategori.id
0049      WHERE menu.status = 'Tersedia'
0050      ORDER BY menu.nama_menu ASC
0051  ")->fetchAll(PDO::FETCH_ASSOC);
0052  
0053  
0054  /* =========================================================
0055     MODE EDIT
0056  ========================================================= */
0057  
0058  if ($id > 0) {
0059  
0060      $stmt = $pdo->prepare("
0061          SELECT
0062              id,
0063              kode_pesanan,
0064              pelanggan_id,
0065              meja_id,
0066              tanggal_pesanan,
0067              status
0068          FROM pesanan
0069          WHERE id = :id
0070      ");
0071  
0072      $stmt->execute([
0073          ':id' => $id
0074      ]);
0075  
0076      $data = $stmt->fetch(PDO::FETCH_ASSOC);
0077  
0078      if (!$data) {
0079          header('Location: index.php');
0080          exit;
0081      }
0082  
0083      $kode_pesanan = $data['kode_pesanan'];
0084      $pelanggan_id = $data['pelanggan_id'];
0085      $meja_id = $data['meja_id'];
0086      $status = $data['status'];
0087  
0088      if (!empty($data['tanggal_pesanan'])) {
0089          $tanggal_pesanan = date(
0090              'Y-m-d\TH:i',
0091              strtotime($data['tanggal_pesanan'])
0092          );
0093      }
0094  
0095      /* Ambil detail pesanan */
0096  
0097      $stmtDetail = $pdo->prepare("
0098          SELECT
0099              detail_pesanan.id,
0100              detail_pesanan.menu_id,
0101              detail_pesanan.jumlah,
0102              detail_pesanan.harga,
0103              detail_pesanan.subtotal,
0104              menu.kode_menu,
0105              menu.nama_menu,
0106              menu.stok,
0107              menu.status
0108          FROM detail_pesanan
0109          INNER JOIN menu
0110              ON detail_pesanan.menu_id = menu.id
0111          WHERE detail_pesanan.pesanan_id = :pesanan_id
0112          ORDER BY detail_pesanan.id ASC
0113      ");
0114  
0115      $stmtDetail->execute([
0116          ':pesanan_id' => $id
0117      ]);
0118  
0119      $detail_lama = $stmtDetail->fetchAll(PDO::FETCH_ASSOC);
0120  }
0121  
0122  ?>
0123  
0124  <?php require_once __DIR__ . '/../../layout/header.php'; ?>
0125  
0126  <div class="container">
0127  
0128      <!-- =====================================================
0129           HEADER HALAMAN
0130      ====================================================== -->
0131  
0132      <section>
0133          <h2>
0134              <?= $aksi === 'edit' ? 'Edit Pesanan' : 'Tambah Pesanan'; ?>
0135          </h2>
0136  
0137          <p>
0138              <?= $aksi === 'edit'
0139                  ? 'Perbarui informasi pesanan dan detail menu.'
0140                  : 'Tambahkan pesanan baru ke dalam sistem.'; ?>
0141          </p>
0142      </section>
0143  
0144  
0145      <!-- =====================================================
0146           FORM PESANAN
0147      ====================================================== -->
0148  
0149      <section>
0150  
0151          <form
0152              action="proses.php"
0153              method="POST"
0154              id="formPesanan"
0155          >
0156  
0157              <?= csrf_field(); ?>
0158  
0159              <input
0160                  type="hidden"
0161                  name="aksi"
0162                  value="<?= htmlspecialchars($aksi); ?>"
0163              >
0164  
0165              <?php if ($id > 0): ?>
0166  
0167                  <input
0168                      type="hidden"
0169                      name="id"
0170                      value="<?= $id; ?>"
0171                  >
0172  
0173              <?php endif; ?>
0174  
0175  
0176              <!-- INFORMASI PESANAN -->
0177  
0178              <div class="form-grid">
0179  
0180                  <div>
0181                      <label for="kode_pesanan">
0182                          Kode Pesanan
0183                      </label>
0184  
0185                      <input
0186                          type="text"
0187                          id="kode_pesanan"
0188                          name="kode_pesanan"
0189                          value="<?= htmlspecialchars($kode_pesanan); ?>"
0190                          placeholder="Contoh: PSN-001"
0191                          required
0192                      >
0193                  </div>
0194  
0195  
0196                  <div>
0197                      <label for="tanggal_pesanan">
0198                          Tanggal Pemesanan
0199                      </label>
0200  
0201                      <input
0202                          type="datetime-local"
0203                          id="tanggal_pesanan"
0204                          name="tanggal_pesanan"
0205                          value="<?= htmlspecialchars($tanggal_pesanan); ?>"
0206                          required
0207                      >
0208                  </div>
0209  
0210  
0211                  <div>
0212                      <label for="pelanggan_id">
0213                          Pelanggan
0214                      </label>
0215  
0216                      <select
0217                          id="pelanggan_id"
0218                          name="pelanggan_id"
0219                          required
0220                      >
0221  
0222                          <option value="">
0223                              -- Pilih Pelanggan --
0224                          </option>
0225  
0226                          <?php foreach ($pelanggan as $p): ?>
0227  
0228                              <option
0229                                  value="<?= $p['id']; ?>"
0230                                  <?= (string)$pelanggan_id === (string)$p['id']
0231                                      ? 'selected'
0232                                      : ''; ?>
0233                              >
0234                                  <?= htmlspecialchars(
0235                                      $p['kode_pelanggan'] . ' - ' . $p['nama']
0236                                  ); ?>
0237                              </option>
0238  
0239                          <?php endforeach; ?>
0240  
0241                      </select>
0242                  </div>
0243  
0244  
0245                  <div>
0246                      <label for="meja_id">
0247                          Meja
0248                      </label>
0249  
0250                      <select
0251                          id="meja_id"
0252                          name="meja_id"
0253                          required
0254                      >
0255  
0256                          <option value="">
0257                              -- Pilih Meja --
0258                          </option>
0259  
0260                          <?php foreach ($meja as $m): ?>
0261  
0262                              <?php
0263                              $isCurrentTable = (string) $meja_id === (string) $m['id'];
0264                              $isAvailableTable = $m['status'] === 'Kosong' || $isCurrentTable;
0265                              ?>
0266  
0267                              <option
0268                                  value="<?= $m['id']; ?>"
0269                                  <?= $isCurrentTable ? 'selected' : ''; ?>
0270                                  <?= !$isAvailableTable ? 'disabled' : ''; ?>
0271                              >
0272                                  <?= htmlspecialchars(
0273                                      'Meja ' . $m['nomor_meja']
0274                                      . ' - Kapasitas ' . $m['kapasitas']
0275                                      . ' - ' . $m['status']
0276                                  ); ?>
0277                              </option>
0278  
0279                          <?php endforeach; ?>
0280  
0281                      </select>
0282                  </div>
0283  
0284  
0285                  <div>
0286                      <label for="status">
0287                          Status Pesanan
0288                      </label>
0289  
0290                      <select
0291                          id="status"
0292                          name="status"
0293                          required
0294                      >
0295  
0296                          <option
0297                              value="Proses"
0298                              <?= $status === 'Proses' ? 'selected' : ''; ?>
0299                          >
0300                              Proses
0301                          </option>
0302  
0303                          <option
0304                              value="Selesai"
0305                              <?= $status === 'Selesai' ? 'selected' : ''; ?>
0306                          >
0307                              Selesai
0308                          </option>
0309  
0310                          <option
0311                              value="Dibatalkan"
0312                              <?= $status === 'Dibatalkan' ? 'selected' : ''; ?>
0313                          >
0314                              Dibatalkan
0315                          </option>
0316  
0317                      </select>
0318                  </div>
0319  
0320              </div>
0321  
0322  
0323              <hr>
0324  
0325  
0326              <!-- =================================================
0327                   DETAIL PESANAN
0328              ================================================== -->
0329  
0330              <div>
0331  
0332                  <h3>Detail Pesanan</h3>
0333  
0334                  <p>
0335                      Pilih menu dan tentukan jumlah pesanan.
0336                  </p>
0337  
0338              </div>
0339  
0340  
0341              <div class="table-wrapper">
0342  
0343                  <table id="tabelDetailPesanan">
0344  
0345                      <thead>
0346  
0347                          <tr>
0348                              <th>Menu</th>
0349                              <th>Harga</th>
0350                              <th>Jumlah</th>
0351                              <th>Subtotal</th>
0352                              <th>Aksi</th>
0353                          </tr>
0354  
0355                      </thead>
0356  
0357                      <tbody id="detailContainer">
0358  
0359                          <?php if (!empty($detail_lama)): ?>
0360  
0361                              <?php foreach ($detail_lama as $detail): ?>
0362  
0363                                  <tr class="detail-row">
0364  
0365                                      <td>
0366  
0367                                          <select
0368                                              name="menu_id[]"
0369                                              class="menu-select"
0370                                              required
0371                                          >
0372  
0373                                              <option value="">
0374                                                  -- Pilih Menu --
0375                                              </option>
0376  
0377                                              <?php foreach ($menu as $m): ?>
0378  
0379                                                  <option
0380                                                      value="<?= $m['id']; ?>"
0381                                                      data-harga="<?= $m['harga']; ?>"
0382                                                      <?= (string)$detail['menu_id'] === (string)$m['id']
0383                                                          ? 'selected'
0384                                                          : ''; ?>
0385                                                  >
0386                                                      <?= htmlspecialchars(
0387                                                          $m['kode_menu']
0388                                                          . ' - '
0389                                                          . $m['nama_menu']
0390                                                      ); ?>
0391                                                  </option>
0392  
0393                                              <?php endforeach; ?>
0394  
0395                                              <?php
0396                                              /*
0397                                               * Jika menu lama sudah tidak
0398                                               * berstatus Tersedia, tetap
0399                                               * tampilkan sebagai pilihan.
0400                                               */
0401                                              $menuLamaAda = false;
0402  
0403                                              foreach ($menu as $m) {
0404                                                  if ((string)$m['id'] === (string)$detail['menu_id']) {
0405                                                      $menuLamaAda = true;
0406                                                      break;
0407                                                  }
0408                                              }
0409                                              ?>
0410  
0411                                              <?php if (!$menuLamaAda): ?>
0412  
0413                                                  <option
0414                                                      value="<?= $detail['menu_id']; ?>"
0415                                                      data-harga="<?= $detail['harga']; ?>"
0416                                                      selected
0417                                                  >
0418                                                      <?= htmlspecialchars(
0419                                                          $detail['kode_menu']
0420                                                          . ' - '
0421                                                          . $detail['nama_menu']
0422                                                      ); ?>
0423                                                  </option>
0424  
0425                                              <?php endif; ?>
0426  
0427                                          </select>
0428  
0429                                      </td>
0430  
0431  
0432                                      <td>
0433  
0434                                          <input
0435                                              type="number"
0436                                              class="harga-input"
0437                                              value="<?= htmlspecialchars($detail['harga']); ?>"
0438                                              readonly
0439                                          >
0440  
0441                                      </td>
0442  
0443  
0444                                      <td>
0445  
0446                                          <input
0447                                              type="number"
0448                                              name="jumlah[]"
0449                                              class="jumlah-input"
0450                                              value="<?= htmlspecialchars($detail['jumlah']); ?>"
0451                                              min="1"
0452                                              required
0453                                          >
0454  
0455                                      </td>
0456  
0457  
0458                                      <td>
0459  
0460                                          <input
0461                                              type="number"
0462                                              class="subtotal-input"
0463                                              value="<?= htmlspecialchars($detail['subtotal']); ?>"
0464                                              readonly
0465                                          >
0466  
0467                                      </td>
0468  
0469  
0470                                      <td>
0471  
0472                                          <button
0473                                              type="button"
0474                                              class="btn-danger btn-hapus-detail"
0475                                          >
0476                                              Hapus
0477                                          </button>
0478  
0479                                      </td>
0480  
0481                                  </tr>
0482  
0483                              <?php endforeach; ?>
0484  
0485                          <?php else: ?>
0486  
0487                              <tr class="detail-row">
0488  
0489                                  <td>
0490  
0491                                      <select
0492                                          name="menu_id[]"
0493                                          class="menu-select"
0494                                          required
0495                                      >
0496  
0497                                          <option value="">
0498                                              -- Pilih Menu --
0499                                          </option>
0500  
0501                                          <?php foreach ($menu as $m): ?>
0502  
0503                                              <option
0504                                                  value="<?= $m['id']; ?>"
0505                                                  data-harga="<?= $m['harga']; ?>"
0506                                              >
0507                                                  <?= htmlspecialchars(
0508                                                      $m['kode_menu']
0509                                                      . ' - '
0510                                                      . $m['nama_menu']
0511                                                  ); ?>
0512                                              </option>
0513  
0514                                          <?php endforeach; ?>
0515  
0516                                      </select>
0517  
0518                                  </td>
0519  
0520  
0521                                  <td>
0522  
0523                                      <input
0524                                          type="number"
0525                                          class="harga-input"
0526                                          readonly
0527                                      >
0528  
0529                                  </td>
0530  
0531  
0532                                  <td>
0533  
0534                                      <input
0535                                          type="number"
0536                                          name="jumlah[]"
0537                                          class="jumlah-input"
0538                                          value="1"
0539                                          min="1"
0540                                          required
0541                                      >
0542  
0543                                  </td>
0544  
0545  
0546                                  <td>
0547  
0548                                      <input
0549                                          type="number"
0550                                          class="subtotal-input"
0551                                          readonly
0552                                      >
0553  
0554                                  </td>
0555  
0556  
0557                                  <td>
0558  
0559                                      <button
0560                                          type="button"
0561                                          class="btn-danger btn-hapus-detail"
0562                                      >
0563                                          Hapus
0564                                      </button>
0565  
0566                                  </td>
0567  
0568                              </tr>
0569  
0570                          <?php endif; ?>
0571  
0572                      </tbody>
0573  
0574                  </table>
0575  
0576              </div>
0577  
0578  
0579              <!-- TAMBAH MENU -->
0580  
0581              <div style="margin-top: 15px;">
0582  
0583                  <button
0584                      type="button"
0585                      id="btnTambahDetail"
0586                  >
0587                      + Tambah Menu
0588                  </button>
0589  
0590              </div>
0591  
0592  
0593              <!-- TOTAL -->
0594  
0595              <div style="
0596                  margin-top: 22px;
0597                  padding: 18px;
0598                  background: #faf5ef;
0599                  border-radius: 10px;
0600                  text-align: right;
0601              ">
0602  
0603                  <strong>Total Pesanan</strong>
0604  
0605                  <div id="totalDisplay">
0606                      Rp 0
0607                  </div>
0608  
0609              </div>
0610  
0611  
0612              <!-- ACTION -->
0613  
0614              <div class="actions">
0615  
0616                  <button type="submit">
0617                      <?= $aksi === 'edit'
0618                          ? 'Simpan Perubahan'
0619                          : 'Simpan Pesanan'; ?>
0620                  </button>
0621  
0622                  <a
0623                      href="index.php"
0624                      class="btn btn-secondary"
0625                  >
0626                      Batal
0627                  </a>
0628  
0629              </div>
0630  
0631          </form>
0632  
0633      </section>
0634  
0635  </div>
0636  
0637  
0638  <script>
0639  
0640  document.addEventListener('DOMContentLoaded', function () {
0641  
0642      const container = document.getElementById('detailContainer');
0643      const btnTambah = document.getElementById('btnTambahDetail');
0644      const totalDisplay = document.getElementById('totalDisplay');
0645  
0646  
0647      function formatRupiah(angka) {
0648  
0649          return new Intl.NumberFormat('id-ID', {
0650              style: 'currency',
0651              currency: 'IDR',
0652              minimumFractionDigits: 0
0653          }).format(angka);
0654  
0655      }
0656  
0657  
0658      function hitungBaris(row) {
0659  
0660          const select = row.querySelector('.menu-select');
0661          const hargaInput = row.querySelector('.harga-input');
0662          const jumlahInput = row.querySelector('.jumlah-input');
0663          const subtotalInput = row.querySelector('.subtotal-input');
0664  
0665          if (!select || !hargaInput || !jumlahInput || !subtotalInput) {
0666              return 0;
0667          }
0668  
0669          const option = select.options[select.selectedIndex];
0670  
0671          const harga = parseFloat(
0672              option?.dataset?.harga || 0
0673          );
0674  
0675          const jumlah = parseInt(
0676              jumlahInput.value || 0
0677          );
0678  
0679          const subtotal = harga * jumlah;
0680  
0681          hargaInput.value = harga;
0682          subtotalInput.value = subtotal;
0683  
0684          return subtotal;
0685      }
0686  
0687  
0688      function hitungTotal() {
0689  
0690          let total = 0;
0691  
0692          document
0693              .querySelectorAll('.detail-row')
0694              .forEach(function (row) {
0695  
0696                  total += hitungBaris(row);
0697  
0698              });
0699  
0700          totalDisplay.textContent = formatRupiah(total);
0701  
0702      }
0703  
0704  
0705      function pasangEvent(row) {
0706  
0707          const select = row.querySelector('.menu-select');
0708          const jumlah = row.querySelector('.jumlah-input');
0709          const tombolHapus = row.querySelector('.btn-hapus-detail');
0710  
0711          if (select) {
0712  
0713              select.addEventListener('change', function () {
0714                  hitungTotal();
0715              });
0716  
0717          }
0718  
0719          if (jumlah) {
0720  
0721              jumlah.addEventListener('input', function () {
0722                  hitungTotal();
0723              });
0724  
0725          }
0726  
0727          if (tombolHapus) {
0728  
0729              tombolHapus.addEventListener('click', function () {
0730  
0731                  const rows = document.querySelectorAll('.detail-row');
0732  
0733                  if (rows.length <= 1) {
0734  
0735                      alert('Minimal harus ada satu menu.');
0736  
0737                      return;
0738                  }
0739  
0740                  row.remove();
0741  
0742                  hitungTotal();
0743  
0744              });
0745  
0746          }
0747  
0748      }
0749  
0750  
0751      document
0752          .querySelectorAll('.detail-row')
0753          .forEach(function (row) {
0754  
0755              pasangEvent(row);
0756  
0757          });
0758  
0759  
0760      btnTambah.addEventListener('click', function () {
0761  
0762          const rowPertama =
0763              document.querySelector('.detail-row');
0764  
0765          const rowBaru =
0766              rowPertama.cloneNode(true);
0767  
0768  
0769          rowBaru
0770              .querySelector('.menu-select')
0771              .selectedIndex = 0;
0772  
0773  
0774          rowBaru
0775              .querySelector('.harga-input')
0776              .value = '';
0777  
0778  
0779          rowBaru
0780              .querySelector('.jumlah-input')
0781              .value = 1;
0782  
0783  
0784          rowBaru
0785              .querySelector('.subtotal-input')
0786              .value = '';
0787  
0788  
0789          container.appendChild(rowBaru);
0790  
0791          pasangEvent(rowBaru);
0792  
0793          hitungTotal();
0794  
0795      });
0796  
0797  
0798      hitungTotal();
0799  
0800  });
0801  
0802  </script>
0803  
0804  
0805  <?php require_once __DIR__ . '/../../layout/footer.php'; ?>
```
### Konsep yang harus bisa dijelaskan
HTML escaping / XSS mitigation, multi-row fetch, parameterized execution, relational join.
### Pertanyaan dosen yang mungkin muncul
- Kenapa menggunakan `prepare()` dan bukan string SQL biasa?
- Bagian mana yang mencegah XSS?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/transaksi/pesanan/proses.php`
**Ukuran:** 235 baris. **Peran:** inti integrasi pesanan: transaction, locking meja/menu, restore stok, detail, total, status meja, commit/rollback.

### Kode asli (line-numbered)
```text
0001  <?php
0002  
0003  require_once __DIR__ . "/../../includes/auth.php";
0004  require __DIR__ . "/../../includes/csrf.php";
0005  require __DIR__ . "/../../config/database.php";
0006  
0007  csrf_verify();
0008  
0009  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
0010      header("Location: index.php");
0011      exit;
0012  }
0013  
0014  $aksi = $_POST['aksi'] ?? '';
0015  $id = !empty($_POST['id']) ? (int) $_POST['id'] : 0;
0016  $kode_pesanan = trim($_POST['kode_pesanan'] ?? '');
0017  $pelanggan_id = !empty($_POST['pelanggan_id']) ? (int) $_POST['pelanggan_id'] : null;
0018  $meja_id = !empty($_POST['meja_id']) ? (int) $_POST['meja_id'] : 0;
0019  $tanggal_pesanan = $_POST['tanggal_pesanan'] ?? '';
0020  $status = $_POST['status'] ?? 'Proses';
0021  $menu_id = $_POST['menu_id'] ?? [];
0022  $jumlah = $_POST['jumlah'] ?? [];
0023  
0024  if ($kode_pesanan === '' || $tanggal_pesanan === '' || $meja_id <= 0) {
0025      header("Location: index.php?pesan=gagal");
0026      exit;
0027  }
0028  
0029  $timestamp = strtotime($tanggal_pesanan);
0030  if ($timestamp === false) {
0031      header("Location: index.php?pesan=gagal");
0032      exit;
0033  }
0034  
0035  $statusValid = ['Proses', 'Selesai', 'Dibatalkan'];
0036  if (!in_array($status, $statusValid, true)) {
0037      header("Location: index.php?pesan=gagal");
0038      exit;
0039  }
0040  
0041  if (!is_array($menu_id) || !is_array($jumlah) || count($menu_id) === 0) {
0042      header("Location: index.php?pesan=gagal");
0043      exit;
0044  }
0045  
0046  $items = [];
0047  foreach ($menu_id as $i => $rawMenuId) {
0048      $menuId = (int) $rawMenuId;
0049      $qty = (int) ($jumlah[$i] ?? 0);
0050  
0051      if ($menuId <= 0 || $qty <= 0) {
0052          header("Location: index.php?pesan=gagal");
0053          exit;
0054      }
0055  
0056      $items[$menuId] = ($items[$menuId] ?? 0) + $qty;
0057  }
0058  
0059  try {
0060      $pdo->beginTransaction();
0061  
0062      $tanggalDb = date('Y-m-d H:i:s', $timestamp);
0063      $pesananId = $id;
0064      $oldStatus = null;
0065      $oldTableId = null;
0066      $oldDetails = [];
0067  
0068      if ($aksi === 'edit') {
0069          if ($id <= 0) {
0070              throw new Exception('ID pesanan tidak valid.');
0071          }
0072  
0073          $stmt = $pdo->prepare("SELECT id, status, meja_id FROM pesanan WHERE id = :id FOR UPDATE");
0074          $stmt->execute([':id' => $id]);
0075          $oldOrder = $stmt->fetch();
0076  
0077          if (!$oldOrder) {
0078              throw new Exception('Pesanan tidak ditemukan.');
0079          }
0080  
0081          $oldStatus = $oldOrder['status'];
0082          $oldTableId = $oldOrder['meja_id'] !== null ? (int) $oldOrder['meja_id'] : null;
0083  
0084          $stmt = $pdo->prepare("SELECT menu_id, jumlah FROM detail_pesanan WHERE pesanan_id = :pesanan_id");
0085          $stmt->execute([':pesanan_id' => $id]);
0086          $oldDetails = $stmt->fetchAll();
0087  
0088          if ($oldStatus !== 'Dibatalkan') {
0089              $restore = $pdo->prepare("UPDATE menu SET stok = stok + :jumlah WHERE id = :id");
0090              foreach ($oldDetails as $detail) {
0091                  $restore->execute([
0092                      ':jumlah' => (int) $detail['jumlah'],
0093                      ':id' => (int) $detail['menu_id']
0094                  ]);
0095              }
0096          }
0097  
0098          // Kunci meja baru sebelum memastikan meja tersebut masih tersedia.
0099          $stmt = $pdo->prepare("SELECT id, status FROM meja WHERE id = :id FOR UPDATE");
0100          $stmt->execute([':id' => $meja_id]);
0101          $newTable = $stmt->fetch();
0102  
0103          if (!$newTable) {
0104              throw new Exception('Meja tidak ditemukan.');
0105          }
0106  
0107          if ($oldTableId !== $meja_id && $newTable['status'] !== 'Kosong') {
0108              throw new Exception('Meja yang dipilih sedang digunakan.');
0109          }
0110  
0111          $stmt = $pdo->prepare("DELETE FROM detail_pesanan WHERE pesanan_id = :pesanan_id");
0112          $stmt->execute([':pesanan_id' => $id]);
0113  
0114          $stmt = $pdo->prepare("UPDATE pesanan SET kode_pesanan = :kode_pesanan, pelanggan_id = :pelanggan_id, meja_id = :meja_id, tanggal_pesanan = :tanggal_pesanan, status = :status WHERE id = :id");
0115          $stmt->execute([
0116              ':kode_pesanan' => $kode_pesanan,
0117              ':pelanggan_id' => $pelanggan_id,
0118              ':meja_id' => $meja_id,
0119              ':tanggal_pesanan' => $tanggalDb,
0120              ':status' => $status,
0121              ':id' => $id
0122          ]);
0123      } elseif ($aksi === 'tambah') {
0124          // Satu meja hanya boleh memiliki satu pesanan aktif pada satu waktu.
0125          $stmt = $pdo->prepare("SELECT id, status FROM meja WHERE id = :id FOR UPDATE");
0126          $stmt->execute([':id' => $meja_id]);
0127          $table = $stmt->fetch();
0128  
0129          if (!$table) {
0130              throw new Exception('Meja tidak ditemukan.');
0131          }
0132  
0133          if ($table['status'] !== 'Kosong') {
0134              throw new Exception('Meja yang dipilih sedang digunakan.');
0135          }
0136  
0137          $stmt = $pdo->prepare("INSERT INTO pesanan (kode_pesanan, pelanggan_id, meja_id, tanggal_pesanan, status, total) VALUES (:kode_pesanan, :pelanggan_id, :meja_id, :tanggal_pesanan, :status, 0) RETURNING id");
0138          $stmt->execute([
0139              ':kode_pesanan' => $kode_pesanan,
0140              ':pelanggan_id' => $pelanggan_id,
0141              ':meja_id' => $meja_id,
0142              ':tanggal_pesanan' => $tanggalDb,
0143              ':status' => $status
0144          ]);
0145          $pesananId = (int) $stmt->fetchColumn();
0146      } else {
0147          throw new Exception('Aksi tidak valid.');
0148      }
0149  
0150      $total = 0;
0151  
0152      foreach ($items as $menuId => $qty) {
0153          $stmtMenu = $pdo->prepare("SELECT id, nama_menu, harga, stok, status FROM menu WHERE id = :id FOR UPDATE");
0154          $stmtMenu->execute([':id' => $menuId]);
0155          $dataMenu = $stmtMenu->fetch();
0156  
0157          if (!$dataMenu) {
0158              throw new Exception('Menu tidak ditemukan.');
0159          }
0160  
0161          if ($status !== 'Dibatalkan') {
0162              if ($dataMenu['status'] !== 'Tersedia') {
0163                  throw new Exception('Menu ' . $dataMenu['nama_menu'] . ' tidak tersedia.');
0164              }
0165  
0166              if ($qty > (int) $dataMenu['stok']) {
0167                  throw new Exception('Stok menu ' . $dataMenu['nama_menu'] . ' tidak mencukupi.');
0168              }
0169          }
0170  
0171          $harga = (float) $dataMenu['harga'];
0172          $subtotal = $harga * $qty;
0173          $total += $subtotal;
0174  
0175          $stmtDetail = $pdo->prepare("INSERT INTO detail_pesanan (pesanan_id, menu_id, jumlah, harga, subtotal) VALUES (:pesanan_id, :menu_id, :jumlah, :harga, :subtotal)");
0176          $stmtDetail->execute([
0177              ':pesanan_id' => $pesananId,
0178              ':menu_id' => $menuId,
0179              ':jumlah' => $qty,
0180              ':harga' => $harga,
0181              ':subtotal' => $subtotal
0182          ]);
0183  
0184          if ($status !== 'Dibatalkan') {
0185              $stmtStock = $pdo->prepare("UPDATE menu SET stok = stok - :jumlah WHERE id = :id AND stok >= :jumlah");
0186              $stmtStock->execute([
0187                  ':jumlah' => $qty,
0188                  ':id' => $menuId
0189              ]);
0190  
0191              if ($stmtStock->rowCount() !== 1) {
0192                  throw new Exception('Stok menu berubah. Silakan coba lagi.');
0193              }
0194          }
0195      }
0196  
0197      $stmtTotal = $pdo->prepare("UPDATE pesanan SET total = :total WHERE id = :id");
0198      $stmtTotal->execute([
0199          ':total' => $total,
0200          ':id' => $pesananId
0201      ]);
0202  
0203      // Pesanan yang dibatalkan tidak lagi memegang meja.
0204      // Pesanan Proses/Selesai tetap membuat meja berstatus Terisi.
0205      if ($status === 'Dibatalkan') {
0206          if ($oldTableId !== null) {
0207              $stmt = $pdo->prepare("UPDATE meja SET status = 'Kosong' WHERE id = :id");
0208              $stmt->execute([':id' => $oldTableId]);
0209          } else {
0210              $stmt = $pdo->prepare("UPDATE meja SET status = 'Kosong' WHERE id = :id");
0211              $stmt->execute([':id' => $meja_id]);
0212          }
0213      } else {
0214          if ($oldTableId !== null && $oldTableId !== $meja_id) {
0215              $stmt = $pdo->prepare("UPDATE meja SET status = 'Kosong' WHERE id = :id");
0216              $stmt->execute([':id' => $oldTableId]);
0217          }
0218  
0219          $stmt = $pdo->prepare("UPDATE meja SET status = 'Terisi' WHERE id = :id");
0220          $stmt->execute([':id' => $meja_id]);
0221      }
0222  
0223      $pdo->commit();
0224  
0225      header("Location: index.php?pesan=" . ($aksi === 'tambah' ? 'tambah' : 'edit'));
0226      exit;
0227  
0228  } catch (Throwable $e) {
0229      if ($pdo->inTransaction()) {
0230          $pdo->rollBack();
0231      }
0232  
0233      header("Location: index.php?pesan=gagal");
0234      exit;
0235  }
```
### Konsep yang harus bisa dijelaskan
CSRF verification, PostgreSQL RETURNING, commit, database transaction, multi-row fetch, parameterized execution, rollback, row locking, single-value fetch.
### Pertanyaan dosen yang mungkin muncul
- Kenapa menggunakan `prepare()` dan bukan string SQL biasa?
- Kenapa proses ini harus memakai transaction?
- Apa yang dikunci oleh `FOR UPDATE`, dan kenapa?
- Kenapa endpoint POST perlu `csrf_verify()`?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/transaksi/pesanan/hapus.php`
**Ukuran:** 66 baris. **Peran:** bagian aplikasi yang menangani halaman/CRUD terkait.

### Kode asli (line-numbered)
```text
0001  <?php
0002  
0003  require_once __DIR__ . "/../../includes/auth.php";
0004  require __DIR__ . "/../../includes/csrf.php";
0005  require __DIR__ . "/../../config/database.php";
0006  
0007  csrf_verify();
0008  
0009  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
0010      header("Location: index.php");
0011      exit;
0012  }
0013  
0014  $id = !empty($_POST['id']) ? (int) $_POST['id'] : 0;
0015  
0016  if ($id <= 0) {
0017      header("Location: index.php?pesan=gagal");
0018      exit;
0019  }
0020  
0021  try {
0022      $pdo->beginTransaction();
0023  
0024      $stmt = $pdo->prepare("SELECT id, status, meja_id FROM pesanan WHERE id = :id FOR UPDATE");
0025      $stmt->execute([':id' => $id]);
0026      $pesanan = $stmt->fetch();
0027  
0028      if (!$pesanan) {
0029          throw new Exception('Pesanan tidak ditemukan.');
0030      }
0031  
0032      $stmt = $pdo->prepare("SELECT menu_id, jumlah FROM detail_pesanan WHERE pesanan_id = :pesanan_id");
0033      $stmt->execute([':pesanan_id' => $id]);
0034      $details = $stmt->fetchAll();
0035  
0036      if ($pesanan['status'] !== 'Dibatalkan') {
0037          $restore = $pdo->prepare("UPDATE menu SET stok = stok + :jumlah WHERE id = :id");
0038          foreach ($details as $detail) {
0039              $restore->execute([
0040                  ':jumlah' => (int) $detail['jumlah'],
0041                  ':id' => (int) $detail['menu_id']
0042              ]);
0043          }
0044      }
0045  
0046      if ($pesanan['meja_id'] !== null) {
0047          $stmt = $pdo->prepare("UPDATE meja SET status = 'Kosong' WHERE id = :id");
0048          $stmt->execute([':id' => (int) $pesanan['meja_id']]);
0049      }
0050  
0051      $stmt = $pdo->prepare("DELETE FROM pesanan WHERE id = :id");
0052      $stmt->execute([':id' => $id]);
0053  
0054      $pdo->commit();
0055  
0056      header("Location: index.php?pesan=hapus");
0057      exit;
0058  
0059  } catch (Throwable $e) {
0060      if ($pdo->inTransaction()) {
0061          $pdo->rollBack();
0062      }
0063  
0064      header("Location: index.php?pesan=gagal");
0065      exit;
0066  }
```
### Konsep yang harus bisa dijelaskan
CSRF verification, commit, database transaction, multi-row fetch, parameterized execution, rollback, row locking.
### Pertanyaan dosen yang mungkin muncul
- Kenapa menggunakan `prepare()` dan bukan string SQL biasa?
- Kenapa proses ini harus memakai transaction?
- Apa yang dikunci oleh `FOR UPDATE`, dan kenapa?
- Kenapa endpoint POST perlu `csrf_verify()`?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/transaksi/pesanan/kosongkan_meja.php`
**Ukuran:** 55 baris. **Peran:** melepas meja setelah pesanan memenuhi syarat selesai.

### Kode asli (line-numbered)
```text
0001  <?php
0002  
0003  require_once __DIR__ . "/../../includes/auth.php";
0004  require __DIR__ . "/../../includes/csrf.php";
0005  require __DIR__ . "/../../config/database.php";
0006  
0007  csrf_verify();
0008  
0009  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
0010      header("Location: index.php");
0011      exit;
0012  }
0013  
0014  $id = !empty($_POST['id']) ? (int) $_POST['id'] : 0;
0015  
0016  if ($id <= 0) {
0017      header("Location: index.php?pesan=gagal");
0018      exit;
0019  }
0020  
0021  try {
0022      $pdo->beginTransaction();
0023  
0024      $stmt = $pdo->prepare("SELECT id, status, meja_id FROM pesanan WHERE id = :id FOR UPDATE");
0025      $stmt->execute([':id' => $id]);
0026      $pesanan = $stmt->fetch();
0027  
0028      if (!$pesanan) {
0029          throw new Exception('Pesanan tidak ditemukan.');
0030      }
0031  
0032      if ($pesanan['status'] !== 'Selesai') {
0033          throw new Exception('Meja hanya dapat dikosongkan setelah pesanan selesai.');
0034      }
0035  
0036      if ($pesanan['meja_id'] === null) {
0037          throw new Exception('Pesanan tidak memiliki meja.');
0038      }
0039  
0040      $stmt = $pdo->prepare("UPDATE meja SET status = 'Kosong' WHERE id = :id");
0041      $stmt->execute([':id' => (int) $pesanan['meja_id']]);
0042  
0043      $pdo->commit();
0044  
0045      header("Location: index.php?pesan=meja_kosong");
0046      exit;
0047  
0048  } catch (Throwable $e) {
0049      if ($pdo->inTransaction()) {
0050          $pdo->rollBack();
0051      }
0052  
0053      header("Location: index.php?pesan=gagal");
0054      exit;
0055  }
```
### Konsep yang harus bisa dijelaskan
CSRF verification, commit, database transaction, parameterized execution, rollback, row locking.
### Pertanyaan dosen yang mungkin muncul
- Kenapa menggunakan `prepare()` dan bukan string SQL biasa?
- Kenapa proses ini harus memakai transaction?
- Apa yang dikunci oleh `FOR UPDATE`, dan kenapa?
- Kenapa endpoint POST perlu `csrf_verify()`?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/transaksi/pembayaran/index.php`
**Ukuran:** 328 baris. **Peran:** bagian aplikasi yang menangani halaman/CRUD terkait.

### Kode asli (line-numbered)
```text
0001  <?php
0002  
0003  require_once __DIR__ . "/../../includes/auth.php";
0004  require __DIR__ . "/../../includes/csrf.php";
0005  
0006  
0007  $page_title = "Pembayaran";
0008  
0009  require __DIR__ . "/../../config/database.php";
0010  
0011  $keyword = trim($_GET['keyword'] ?? '');
0012  $page = max(1, (int) ($_GET['page'] ?? 1));
0013  $perPage = 5;
0014  
0015  $whereSql = '';
0016  $params = [];
0017  
0018  if ($keyword !== '') {
0019      $whereSql = "WHERE (pesanan.kode_pesanan ILIKE :keyword OR pelanggan.nama ILIKE :keyword OR pembayaran.metode_pembayaran ILIKE :keyword OR pembayaran.status ILIKE :keyword)";
0020      $params[':keyword'] = '%' . $keyword . '%';
0021  }
0022  
0023  $countStmt = $pdo->prepare("
0024      SELECT COUNT(*)
0025      FROM pembayaran INNER JOIN pesanan ON pembayaran.pesanan_id = pesanan.id LEFT JOIN pelanggan ON pesanan.pelanggan_id = pelanggan.id
0026      $whereSql
0027  ");
0028  $countStmt->execute($params);
0029  $totalData = (int) $countStmt->fetchColumn();
0030  $totalPages = max(1, (int) ceil($totalData / $perPage));
0031  $page = min($page, $totalPages);
0032  $offset = ($page - 1) * $perPage;
0033  
0034  $query = $pdo->prepare("
0035      SELECT
0036          pembayaran.id,
0037          pesanan.kode_pesanan,
0038          pelanggan.nama AS nama_pelanggan,
0039          pembayaran.tanggal_bayar,
0040          pembayaran.total_bayar,
0041          pembayaran.metode_pembayaran,
0042          pembayaran.status
0043      FROM pembayaran INNER JOIN pesanan ON pembayaran.pesanan_id = pesanan.id LEFT JOIN pelanggan ON pesanan.pelanggan_id = pelanggan.id
0044      $whereSql
0045      ORDER BY pembayaran.id DESC
0046      LIMIT :limit OFFSET :offset
0047  ");
0048  
0049  foreach ($params as $name => $value) {
0050      $query->bindValue($name, $value, PDO::PARAM_STR);
0051  }
0052  $query->bindValue(':limit', $perPage, PDO::PARAM_INT);
0053  $query->bindValue(':offset', $offset, PDO::PARAM_INT);
0054  $query->execute();
0055  
0056  $pembayaran = $query->fetchAll(PDO::FETCH_ASSOC);
0057  
0058  $pesan = $_GET['pesan'] ?? '';
0059  
0060  ?>
0061  
0062  <?php require __DIR__ . "/../../layout/header.php"; ?>
0063  
0064  <section>
0065  
0066      <div style="
0067          display: flex;
0068          justify-content: space-between;
0069          align-items: center;
0070          gap: 15px;
0071          flex-wrap: wrap;
0072      ">
0073  
0074          <div>
0075  
0076              <h2>
0077                  Data Pembayaran
0078              </h2>
0079  
0080              <p>
0081                  Kelola pembayaran transaksi Cafe_Najwa.
0082              </p>
0083  
0084          </div>
0085  
0086          <a
0087              href="form.php"
0088              class="btn">
0089  
0090              + Tambah Pembayaran
0091  
0092          </a>
0093  
0094      </div>
0095  
0096  </section>
0097  
0098  
0099  <?php if ($pesan === 'tambah'): ?>
0100  
0101      <section>
0102          <p>
0103              ✅ Pembayaran berhasil ditambahkan.
0104          </p>
0105      </section>
0106  
0107  <?php elseif ($pesan === 'edit'): ?>
0108  
0109      <section>
0110          <p>
0111              ✅ Pembayaran berhasil diperbarui.
0112          </p>
0113      </section>
0114  
0115  <?php elseif ($pesan === 'hapus'): ?>
0116  
0117      <section>
0118          <p>
0119              ✅ Pembayaran berhasil dihapus.
0120          </p>
0121      </section>
0122  
0123  <?php elseif ($pesan === 'gagal'): ?>
0124  
0125      <section>
0126          <p>
0127              ❌ Proses pembayaran gagal dilakukan.
0128          </p>
0129      </section>
0130  
0131  <?php endif; ?>
0132  
0133  
0134  <section>
0135  
0136      <form method="GET" class="search-form" style="margin-bottom: 15px;">
0137  
0138          <input
0139              type="text"
0140              name="keyword"
0141              value="<?= htmlspecialchars($keyword); ?>"
0142              placeholder="Cari kode pesanan, pelanggan, metode, atau status..."
0143          >
0144  
0145          <button type="submit" class="btn">
0146              Cari
0147          </button>
0148  
0149          <?php if ($keyword !== ''): ?>
0150              <a href="index.php" class="btn">Reset</a>
0151          <?php endif; ?>
0152  
0153      </form>
0154  
0155  
0156      <div class="table-responsive">
0157  
0158          <table id="tabelPembayaran">
0159  
0160              <thead>
0161  
0162                  <tr>
0163  
0164                      <th>No</th>
0165                      <th>Kode Pesanan</th>
0166                      <th>Pelanggan</th>
0167                      <th>Tanggal Bayar</th>
0168                      <th>Total Bayar</th>
0169                      <th>Metode</th>
0170                      <th>Status</th>
0171                      <th>Aksi</th>
0172  
0173                  </tr>
0174  
0175              </thead>
0176  
0177  
0178              <tbody>
0179  
0180                  <?php if (count($pembayaran) > 0): ?>
0181  
0182                      <?php foreach (
0183                          $pembayaran as $index => $data
0184                      ): ?>
0185  
0186                          <tr>
0187  
0188                              <td>
0189                                  <?= $offset + $index + 1; ?>
0190                              </td>
0191  
0192  
0193                              <td>
0194                                  <?= htmlspecialchars(
0195                                      $data['kode_pesanan']
0196                                  ); ?>
0197                              </td>
0198  
0199  
0200                              <td>
0201                                  <?= htmlspecialchars(
0202                                      $data['nama_pelanggan'] ?? '-'
0203                                  ); ?>
0204                              </td>
0205  
0206  
0207                              <td>
0208                                  <?= date(
0209                                      'd-m-Y H:i',
0210                                      strtotime(
0211                                          $data['tanggal_bayar']
0212                                      )
0213                                  ); ?>
0214                              </td>
0215  
0216  
0217                              <td>
0218  
0219                                  Rp
0220                                  <?= number_format(
0221                                      $data['total_bayar'],
0222                                      0,
0223                                      ',',
0224                                      '.'
0225                                  ); ?>
0226  
0227                              </td>
0228  
0229  
0230                              <td>
0231                                  <?= htmlspecialchars(
0232                                      $data['metode_pembayaran']
0233                                  ); ?>
0234                              </td>
0235  
0236  
0237                              <td>
0238                                  <?= htmlspecialchars(
0239                                      $data['status']
0240                                  ); ?>
0241                              </td>
0242  
0243  
0244                              <td>
0245  
0246                                  <div class="actions">
0247  
0248                                      <a
0249                                          href="form.php?id=<?= $data['id']; ?>"
0250                                          class="btn">
0251  
0252                                          Edit
0253  
0254                                      </a>
0255  
0256  
0257                                      <form action="hapus.php" method="POST" class="form-hapus">
0258                                          <?= csrf_field(); ?>
0259                                          <input type="hidden" name="id" value="<?= $data['id']; ?>">
0260                                          <button type="submit" class="btn btn-hapus">
0261                                              Hapus
0262                                          </button>
0263                                      </form>
0264  
0265                                  </div>
0266  
0267                              </td>
0268  
0269                          </tr>
0270  
0271                      <?php endforeach; ?>
0272  
0273  
0274                  <?php else: ?>
0275  
0276                      <tr>
0277  
0278                          <td colspan="8">
0279  
0280                              Belum ada data pembayaran.
0281  
0282                          </td>
0283  
0284                      </tr>
0285  
0286                  <?php endif; ?>
0287  
0288              </tbody>
0289  
0290          </table>
0291  
0292      </div>
0293  
0294  </section>
0295  
0296  
0297  <div class="pagination-wrapper">
0298  
0299      <?php if ($totalPages > 1): ?>
0300  
0301          <div class="pagination">
0302  
0303              <?php if ($page > 1): ?>
0304                  <a href="?page=<?= $page - 1; ?>&keyword=<?= urlencode($keyword); ?>">
0305                      ← Sebelumnya
0306                  </a>
0307              <?php endif; ?>
0308  
0309              <?php for ($i = 1; $i <= $totalPages; $i++): ?>
0310                  <a href="?page=<?= $i; ?>&keyword=<?= urlencode($keyword); ?>" class="<?= $i === $page ? 'active' : ''; ?>">
0311                      <?= $i; ?>
0312                  </a>
0313              <?php endfor; ?>
0314  
0315              <?php if ($page < $totalPages): ?>
0316                  <a href="?page=<?= $page + 1; ?>&keyword=<?= urlencode($keyword); ?>">
0317                      Berikutnya →
0318                  </a>
0319              <?php endif; ?>
0320  
0321          </div>
0322  
0323      <?php endif; ?>
0324  
0325  </div>
0326  
0327  
0328  <?php require __DIR__ . "/../../layout/footer.php"; ?>
```
### Konsep yang harus bisa dijelaskan
HTML escaping / XSS mitigation, PostgreSQL case-insensitive search, multi-row fetch, pagination, parameterized execution, relational join, single-value fetch.
### Pertanyaan dosen yang mungkin muncul
- Kenapa menggunakan `prepare()` dan bukan string SQL biasa?
- Bagian mana yang mencegah XSS?
- Kenapa memakai `ILIKE`?
- Bagaimana rumus pagination dan dari mana `LIMIT/OFFSET` berasal?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/transaksi/pembayaran/form.php`
**Ukuran:** 525 baris. **Peran:** bagian aplikasi yang menangani halaman/CRUD terkait.

### Kode asli (line-numbered)
```text
0001  <?php
0002  
0003  require_once __DIR__ . "/../../includes/auth.php";
0004  require __DIR__ . "/../../includes/csrf.php";
0005  
0006  
0007  require __DIR__ . "/../../config/database.php";
0008  
0009  $id = $_GET['id'] ?? null;
0010  
0011  $edit = false;
0012  
0013  $pesanan_id = '';
0014  $tanggal_bayar = date('Y-m-d\TH:i');
0015  $total_bayar = '';
0016  $metode_pembayaran = 'Cash';
0017  $status = 'Lunas';
0018  
0019  
0020  /*
0021  |--------------------------------------------------------------------------
0022  | DATA PESANAN
0023  |--------------------------------------------------------------------------
0024  | Hanya mengambil pesanan yang belum memiliki pembayaran.
0025  | Saat edit, pembayaran yang sedang diedit tetap dapat ditampilkan.
0026  |--------------------------------------------------------------------------
0027  */
0028  
0029  $queryPesanan = $pdo->query("
0030      SELECT
0031          pesanan.id,
0032          pesanan.kode_pesanan,
0033          pesanan.total,
0034          pelanggan.nama AS nama_pelanggan
0035      FROM pesanan
0036      LEFT JOIN pelanggan
0037          ON pesanan.pelanggan_id = pelanggan.id
0038      LEFT JOIN pembayaran
0039          ON pembayaran.pesanan_id = pesanan.id
0040      WHERE pembayaran.id IS NULL
0041      ORDER BY pesanan.id DESC
0042  ");
0043  
0044  $pesanan = $queryPesanan->fetchAll();
0045  
0046  
0047  /*
0048  |--------------------------------------------------------------------------
0049  | MODE EDIT
0050  |--------------------------------------------------------------------------
0051  */
0052  
0053  if ($id !== null) {
0054  
0055      $stmt = $pdo->prepare("
0056          SELECT
0057              pembayaran.id,
0058              pembayaran.pesanan_id,
0059              pembayaran.tanggal_bayar,
0060              pembayaran.total_bayar,
0061              pembayaran.metode_pembayaran,
0062              pembayaran.status,
0063              pesanan.kode_pesanan,
0064              pesanan.total,
0065              pelanggan.nama AS nama_pelanggan
0066          FROM pembayaran
0067          INNER JOIN pesanan
0068              ON pembayaran.pesanan_id = pesanan.id
0069          LEFT JOIN pelanggan
0070              ON pesanan.pelanggan_id = pelanggan.id
0071          WHERE pembayaran.id = :id
0072      ");
0073  
0074      $stmt->execute([
0075          ':id' => $id
0076      ]);
0077  
0078      $data = $stmt->fetch();
0079  
0080      if (!$data) {
0081  
0082          header("Location: index.php?pesan=gagal");
0083          exit;
0084  
0085      }
0086  
0087      $edit = true;
0088  
0089      $pesanan_id = $data['pesanan_id'];
0090  
0091      /*
0092      | Ubah format timestamp database
0093      | menjadi format yang dapat dibaca
0094      | oleh input datetime-local.
0095      */
0096  
0097      $tanggal_bayar = date(
0098          'Y-m-d\TH:i',
0099          strtotime($data['tanggal_bayar'])
0100      );
0101  
0102      $total_bayar = $data['total_bayar'];
0103  
0104      $metode_pembayaran =
0105          $data['metode_pembayaran'];
0106  
0107      $status =
0108          $data['status'];
0109  
0110  
0111      /*
0112      | Tambahkan pesanan yang sedang diedit
0113      | ke daftar pilihan jika belum ada.
0114      */
0115  
0116      $sudahAda = false;
0117  
0118      foreach ($pesanan as $item) {
0119  
0120          if (
0121              (int) $item['id'] ===
0122              (int) $pesanan_id
0123          ) {
0124  
0125              $sudahAda = true;
0126              break;
0127  
0128          }
0129  
0130      }
0131  
0132  
0133      if (!$sudahAda) {
0134  
0135          $pesanan[] = [
0136  
0137              'id' =>
0138                  $data['pesanan_id'],
0139  
0140              'kode_pesanan' =>
0141                  $data['kode_pesanan'],
0142  
0143              'total' =>
0144                  $data['total'],
0145  
0146              'nama_pelanggan' =>
0147                  $data['nama_pelanggan']
0148  
0149          ];
0150  
0151      }
0152  
0153  }
0154  
0155  
0156  $page_title = $edit
0157      ? "Edit Pembayaran"
0158      : "Tambah Pembayaran";
0159  
0160  ?>
0161  
0162  <?php require __DIR__ . "/../../layout/header.php"; ?>
0163  
0164  
0165  <!-- =====================================================
0166       JUDUL
0167  ===================================================== -->
0168  
0169  <section>
0170  
0171      <h2>
0172          <?= $edit
0173              ? 'Edit Pembayaran'
0174              : 'Tambah Pembayaran';
0175          ?>
0176      </h2>
0177  
0178      <p>
0179          <?= $edit
0180              ? 'Perbarui data pembayaran Cafe_Najwa.'
0181              : 'Catat pembayaran dari pesanan yang sudah dibuat.';
0182          ?>
0183      </p>
0184  
0185  </section>
0186  
0187  
0188  <!-- =====================================================
0189       FORM PEMBAYARAN
0190  ===================================================== -->
0191  
0192  <section>
0193  
0194      <form
0195          action="proses.php"
0196          method="POST"
0197          id="formPembayaran">
0198  
0199              <?= csrf_field(); ?>
0200  
0201  
0202          <!-- ID SAAT EDIT -->
0203  
0204          <?php if ($edit): ?>
0205  
0206              <input
0207                  type="hidden"
0208                  name="id"
0209                  value="<?= htmlspecialchars($id); ?>">
0210  
0211          <?php endif; ?>
0212  
0213  
0214          <!-- AKSI -->
0215  
0216          <input
0217              type="hidden"
0218              name="aksi"
0219              value="<?= $edit ? 'edit' : 'tambah'; ?>">
0220  
0221  
0222          <!-- =================================================
0223               PESANAN
0224          ================================================== -->
0225  
0226          <div>
0227  
0228              <label for="pesanan_id">
0229                  Pesanan
0230              </label>
0231  
0232              <select
0233                  id="pesanan_id"
0234                  name="pesanan_id"
0235                  required>
0236  
0237                  <option value="">
0238                      -- Pilih Pesanan --
0239                  </option>
0240  
0241  
0242                  <?php foreach ($pesanan as $dataPesanan): ?>
0243  
0244                      <option
0245                          value="<?= $dataPesanan['id']; ?>"
0246                          data-total="<?= $dataPesanan['total']; ?>"
0247                          <?= (string) $pesanan_id ===
0248                              (string) $dataPesanan['id']
0249                              ? 'selected'
0250                              : '';
0251                          ?>>
0252  
0253                          <?= htmlspecialchars(
0254                              $dataPesanan['kode_pesanan']
0255                          ); ?>
0256  
0257                          -
0258  
0259                          <?= htmlspecialchars(
0260                              $dataPesanan['nama_pelanggan'] ?? '-'
0261                          ); ?>
0262  
0263                          -
0264  
0265                          Rp
0266  
0267                          <?= number_format(
0268                              $dataPesanan['total'],
0269                              0,
0270                              ',',
0271                              '.'
0272                          ); ?>
0273  
0274                      </option>
0275  
0276                  <?php endforeach; ?>
0277  
0278              </select>
0279  
0280  
0281              <?php if (
0282                  count($pesanan) === 0 &&
0283                  !$edit
0284              ): ?>
0285  
0286                  <small>
0287                      Belum ada pesanan yang dapat dibayar.
0288                  </small>
0289  
0290              <?php endif; ?>
0291  
0292          </div>
0293  
0294  
0295          <!-- =================================================
0296               TANGGAL PEMBAYARAN
0297          ================================================== -->
0298  
0299          <div>
0300  
0301              <label for="tanggal_bayar">
0302                  Tanggal Pembayaran
0303              </label>
0304  
0305              <input
0306                  type="datetime-local"
0307                  id="tanggal_bayar"
0308                  name="tanggal_bayar"
0309                  value="<?= htmlspecialchars(
0310                      $tanggal_bayar
0311                  ); ?>"
0312                  required>
0313  
0314          </div>
0315  
0316  
0317          <!-- =================================================
0318               TOTAL BAYAR
0319          ================================================== -->
0320  
0321          <div>
0322  
0323              <label for="total_bayar">
0324                  Total Bayar
0325              </label>
0326  
0327              <input
0328                  type="number"
0329                  id="total_bayar"
0330                  name="total_bayar"
0331                  value="<?= htmlspecialchars(
0332                      $total_bayar
0333                  ); ?>"
0334                  min="0"
0335                  step="0.01"
0336                  placeholder="Masukkan total pembayaran"
0337                  required>
0338  
0339          </div>
0340  
0341  
0342          <!-- =================================================
0343               METODE PEMBAYARAN
0344          ================================================== -->
0345  
0346          <div>
0347  
0348              <label for="metode_pembayaran">
0349                  Metode Pembayaran
0350              </label>
0351  
0352              <select
0353                  id="metode_pembayaran"
0354                  name="metode_pembayaran"
0355                  required>
0356  
0357                  <option
0358                      value="Cash"
0359                      <?= $metode_pembayaran === 'Cash'
0360                          ? 'selected'
0361                          : '';
0362                      ?>>
0363                      Cash
0364                  </option>
0365  
0366                  <option
0367                      value="QRIS"
0368                      <?= $metode_pembayaran === 'QRIS'
0369                          ? 'selected'
0370                          : '';
0371                      ?>>
0372                      QRIS
0373                  </option>
0374  
0375                  <option
0376                      value="Debit"
0377                      <?= $metode_pembayaran === 'Debit'
0378                          ? 'selected'
0379                          : '';
0380                      ?>>
0381                      Debit
0382                  </option>
0383  
0384                  <option
0385                      value="E-Wallet"
0386                      <?= $metode_pembayaran === 'E-Wallet'
0387                          ? 'selected'
0388                          : '';
0389                      ?>>
0390                      E-Wallet
0391                  </option>
0392  
0393              </select>
0394  
0395          </div>
0396  
0397  
0398          <!-- =================================================
0399               STATUS PEMBAYARAN
0400          ================================================== -->
0401  
0402          <div>
0403  
0404              <label for="status">
0405                  Status Pembayaran
0406              </label>
0407  
0408              <select
0409                  id="status"
0410                  name="status"
0411                  required>
0412  
0413                  <option
0414                      value="Lunas"
0415                      <?= $status === 'Lunas'
0416                          ? 'selected'
0417                          : '';
0418                      ?>>
0419                      Lunas
0420                  </option>
0421  
0422                  <option
0423                      value="Belum Lunas"
0424                      <?= $status === 'Belum Lunas'
0425                          ? 'selected'
0426                          : '';
0427                      ?>>
0428                      Belum Lunas
0429                  </option>
0430  
0431              </select>
0432  
0433          </div>
0434  
0435  
0436          <!-- =================================================
0437               TOMBOL
0438          ================================================== -->
0439  
0440          <div class="actions">
0441  
0442              <button type="submit">
0443  
0444                  <?= $edit
0445                      ? 'Simpan Perubahan'
0446                      : 'Simpan Pembayaran';
0447                  ?>
0448  
0449              </button>
0450  
0451  
0452              <a
0453                  href="index.php"
0454                  class="btn">
0455  
0456                  Batal
0457  
0458              </a>
0459  
0460          </div>
0461  
0462      </form>
0463  
0464  </section>
0465  
0466  
0467  <!-- =====================================================
0468       JAVASCRIPT
0469  ===================================================== -->
0470  
0471  <script>
0472  
0473  document.addEventListener(
0474      "DOMContentLoaded",
0475      function () {
0476  
0477          const pesananSelect =
0478              document.getElementById(
0479                  "pesanan_id"
0480              );
0481  
0482          const totalBayar =
0483              document.getElementById(
0484                  "total_bayar"
0485              );
0486  
0487  
0488          pesananSelect.addEventListener(
0489              "change",
0490              function () {
0491  
0492                  const option =
0493                      pesananSelect.options[
0494                          pesananSelect.selectedIndex
0495                      ];
0496  
0497  
0498                  if (!option) {
0499                      return;
0500                  }
0501  
0502  
0503                  const total =
0504                      option.getAttribute(
0505                          "data-total"
0506                      );
0507  
0508  
0509                  if (total !== null) {
0510  
0511                      totalBayar.value =
0512                          Number(total);
0513  
0514                  }
0515  
0516              }
0517          );
0518  
0519      }
0520  );
0521  
0522  </script>
0523  
0524  
0525  <?php require __DIR__ . "/../../layout/footer.php"; ?>
```
### Konsep yang harus bisa dijelaskan
HTML escaping / XSS mitigation, multi-row fetch, parameterized execution, relational join.
### Pertanyaan dosen yang mungkin muncul
- Kenapa menggunakan `prepare()` dan bukan string SQL biasa?
- Bagian mana yang mencegah XSS?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/transaksi/pembayaran/proses.php`
**Ukuran:** 118 baris. **Peran:** validasi dan penyimpanan pembayaran dengan transaction dan row locking.

### Kode asli (line-numbered)
```text
0001  <?php
0002  
0003  require_once __DIR__ . "/../../includes/auth.php";
0004  require __DIR__ . "/../../includes/csrf.php";
0005  require __DIR__ . "/../../config/database.php";
0006  
0007  csrf_verify();
0008  
0009  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
0010      header("Location: index.php");
0011      exit;
0012  }
0013  
0014  $aksi = $_POST['aksi'] ?? '';
0015  $id = !empty($_POST['id']) ? (int) $_POST['id'] : 0;
0016  $pesanan_id = !empty($_POST['pesanan_id']) ? (int) $_POST['pesanan_id'] : 0;
0017  $tanggal_bayar = $_POST['tanggal_bayar'] ?? '';
0018  $total_bayar = isset($_POST['total_bayar']) ? (float) $_POST['total_bayar'] : 0;
0019  $metode = $_POST['metode_pembayaran'] ?? '';
0020  $status = $_POST['status'] ?? 'Lunas';
0021  
0022  $metodeValid = ['Cash', 'QRIS', 'Debit', 'E-Wallet'];
0023  $statusValid = ['Lunas', 'Belum Lunas'];
0024  
0025  if ($pesanan_id <= 0 || $tanggal_bayar === '' || $total_bayar < 0 || !in_array($metode, $metodeValid, true) || !in_array($status, $statusValid, true)) {
0026      header("Location: index.php?pesan=gagal");
0027      exit;
0028  }
0029  
0030  $timestamp = strtotime($tanggal_bayar);
0031  if ($timestamp === false) {
0032      header("Location: index.php?pesan=gagal");
0033      exit;
0034  }
0035  
0036  try {
0037      $pdo->beginTransaction();
0038  
0039      $stmtPesanan = $pdo->prepare("SELECT id, total, status FROM pesanan WHERE id = :id FOR UPDATE");
0040      $stmtPesanan->execute([':id' => $pesanan_id]);
0041      $pesanan = $stmtPesanan->fetch();
0042  
0043      if (!$pesanan) {
0044          throw new Exception('Pesanan tidak ditemukan.');
0045      }
0046  
0047      if ($pesanan['status'] === 'Dibatalkan') {
0048          throw new Exception('Pesanan yang dibatalkan tidak dapat dibayar.');
0049      }
0050  
0051      $totalPesanan = (float) $pesanan['total'];
0052  
0053      if ($status === 'Lunas' && abs($total_bayar - $totalPesanan) > 0.009) {
0054          throw new Exception('Pembayaran berstatus Lunas harus sama dengan total pesanan.');
0055      }
0056  
0057      if ($status === 'Belum Lunas' && $total_bayar > $totalPesanan) {
0058          throw new Exception('Total pembayaran melebihi total pesanan.');
0059      }
0060  
0061      if ($aksi === 'tambah') {
0062          $cek = $pdo->prepare("SELECT id FROM pembayaran WHERE pesanan_id = :pesanan_id FOR UPDATE");
0063          $cek->execute([':pesanan_id' => $pesanan_id]);
0064          if ($cek->fetch()) {
0065              throw new Exception('Pesanan sudah memiliki pembayaran.');
0066          }
0067  
0068          $stmt = $pdo->prepare("INSERT INTO pembayaran (pesanan_id, tanggal_bayar, total_bayar, metode_pembayaran, status) VALUES (:pesanan_id, :tanggal_bayar, :total_bayar, :metode_pembayaran, :status)");
0069          $stmt->execute([
0070              ':pesanan_id' => $pesanan_id,
0071              ':tanggal_bayar' => date('Y-m-d H:i:s', $timestamp),
0072              ':total_bayar' => $total_bayar,
0073              ':metode_pembayaran' => $metode,
0074              ':status' => $status
0075          ]);
0076      } elseif ($aksi === 'edit') {
0077          if ($id <= 0) {
0078              throw new Exception('ID pembayaran tidak valid.');
0079          }
0080  
0081          $stmt = $pdo->prepare("SELECT id FROM pembayaran WHERE id = :id FOR UPDATE");
0082          $stmt->execute([':id' => $id]);
0083          if (!$stmt->fetch()) {
0084              throw new Exception('Pembayaran tidak ditemukan.');
0085          }
0086  
0087          $stmt = $pdo->prepare("SELECT id FROM pembayaran WHERE pesanan_id = :pesanan_id AND id <> :id");
0088          $stmt->execute([':pesanan_id' => $pesanan_id, ':id' => $id]);
0089          if ($stmt->fetch()) {
0090              throw new Exception('Pesanan sudah memiliki pembayaran lain.');
0091          }
0092  
0093          $stmt = $pdo->prepare("UPDATE pembayaran SET pesanan_id = :pesanan_id, tanggal_bayar = :tanggal_bayar, total_bayar = :total_bayar, metode_pembayaran = :metode_pembayaran, status = :status WHERE id = :id");
0094          $stmt->execute([
0095              ':pesanan_id' => $pesanan_id,
0096              ':tanggal_bayar' => date('Y-m-d H:i:s', $timestamp),
0097              ':total_bayar' => $total_bayar,
0098              ':metode_pembayaran' => $metode,
0099              ':status' => $status,
0100              ':id' => $id
0101          ]);
0102      } else {
0103          throw new Exception('Aksi tidak valid.');
0104      }
0105  
0106      $pdo->commit();
0107  
0108      header("Location: index.php?pesan=" . ($aksi === 'tambah' ? 'tambah' : 'edit'));
0109      exit;
0110  
0111  } catch (Throwable $e) {
0112      if ($pdo->inTransaction()) {
0113          $pdo->rollBack();
0114      }
0115  
0116      header("Location: index.php?pesan=gagal");
0117      exit;
0118  }
```
### Konsep yang harus bisa dijelaskan
CSRF verification, commit, database transaction, parameterized execution, rollback, row locking.
### Pertanyaan dosen yang mungkin muncul
- Kenapa menggunakan `prepare()` dan bukan string SQL biasa?
- Kenapa proses ini harus memakai transaction?
- Apa yang dikunci oleh `FOR UPDATE`, dan kenapa?
- Kenapa endpoint POST perlu `csrf_verify()`?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/transaksi/pembayaran/hapus.php`
**Ukuran:** 50 baris. **Peran:** bagian aplikasi yang menangani halaman/CRUD terkait.

### Kode asli (line-numbered)
```text
0001  <?php
0002  
0003  require_once __DIR__ . "/../../includes/auth.php";
0004  require __DIR__ . "/../../includes/csrf.php";
0005  require __DIR__ . "/../../config/database.php";
0006  
0007  csrf_verify();
0008  
0009  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
0010      header("Location: index.php");
0011      exit;
0012  }
0013  
0014  $id = !empty($_POST['id']) ? (int) $_POST['id'] : 0;
0015  
0016  if ($id <= 0) {
0017      header("Location: index.php?pesan=gagal");
0018      exit;
0019  }
0020  
0021  try {
0022      $pdo->beginTransaction();
0023  
0024      $stmt = $pdo->prepare("SELECT id, pesanan_id FROM pembayaran WHERE id = :id FOR UPDATE");
0025      $stmt->execute([':id' => $id]);
0026      $pembayaran = $stmt->fetch();
0027  
0028      if (!$pembayaran) {
0029          throw new Exception('Pembayaran tidak ditemukan.');
0030      }
0031  
0032      $stmt = $pdo->prepare("DELETE FROM pembayaran WHERE id = :id");
0033      $stmt->execute([':id' => $id]);
0034  
0035      $stmt = $pdo->prepare("UPDATE pesanan SET status = 'Proses' WHERE id = :id AND status <> 'Dibatalkan'");
0036      $stmt->execute([':id' => $pembayaran['pesanan_id']]);
0037  
0038      $pdo->commit();
0039  
0040      header("Location: index.php?pesan=hapus");
0041      exit;
0042  
0043  } catch (Throwable $e) {
0044      if ($pdo->inTransaction()) {
0045          $pdo->rollBack();
0046      }
0047  
0048      header("Location: index.php?pesan=gagal");
0049      exit;
0050  }
```
### Konsep yang harus bisa dijelaskan
CSRF verification, commit, database transaction, parameterized execution, rollback, row locking.
### Pertanyaan dosen yang mungkin muncul
- Kenapa menggunakan `prepare()` dan bukan string SQL biasa?
- Kenapa proses ini harus memakai transaction?
- Apa yang dikunci oleh `FOR UPDATE`, dan kenapa?
- Kenapa endpoint POST perlu `csrf_verify()`?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/sql/database.sql`
**Ukuran:** 243 baris. **Peran:** schema PostgreSQL dan constraint tabel.

### Kode asli (line-numbered)
```text
0001  -- =========================================================
0002  -- DATABASE KAFEIN
0003  -- Sistem Informasi Manajemen Kafe
0004  -- PostgreSQL
0005  -- =========================================================
0006  
0007  
0008  -- =========================================================
0009  -- 1. TABEL KATEGORI
0010  -- =========================================================
0011  
0012  CREATE TABLE IF NOT EXISTS kategori (
0013      id SERIAL PRIMARY KEY,
0014      nama_kategori VARCHAR(100) NOT NULL UNIQUE
0015  );
0016  
0017  
0018  -- =========================================================
0019  -- 2. TABEL MENU
0020  -- =========================================================
0021  
0022  CREATE TABLE IF NOT EXISTS menu (
0023      id SERIAL PRIMARY KEY,
0024  
0025      kode_menu VARCHAR(20) NOT NULL UNIQUE,
0026  
0027      nama_menu VARCHAR(150) NOT NULL,
0028  
0029      kategori_id INTEGER NOT NULL,
0030  
0031      harga NUMERIC(12,2) NOT NULL
0032          CHECK (harga >= 0),
0033  
0034      stok INTEGER NOT NULL DEFAULT 0
0035          CHECK (stok >= 0),
0036  
0037      status VARCHAR(20) NOT NULL DEFAULT 'Tersedia'
0038          CHECK (status IN ('Tersedia', 'Tidak Tersedia')),
0039  
0040      CONSTRAINT fk_menu_kategori
0041          FOREIGN KEY (kategori_id)
0042          REFERENCES kategori(id)
0043          ON UPDATE CASCADE
0044          ON DELETE RESTRICT
0045  );
0046  
0047  
0048  -- =========================================================
0049  -- 3. TABEL PELANGGAN
0050  -- =========================================================
0051  
0052  CREATE TABLE IF NOT EXISTS pelanggan (
0053      id SERIAL PRIMARY KEY,
0054  
0055      kode_pelanggan VARCHAR(20) NOT NULL UNIQUE,
0056  
0057      nama VARCHAR(150) NOT NULL,
0058  
0059      no_hp VARCHAR(30),
0060  
0061      email VARCHAR(150)
0062  );
0063  
0064  
0065  -- =========================================================
0066  -- 4. TABEL MEJA
0067  -- =========================================================
0068  
0069  CREATE TABLE IF NOT EXISTS meja (
0070      id SERIAL PRIMARY KEY,
0071  
0072      nomor_meja VARCHAR(20) NOT NULL UNIQUE,
0073  
0074      kapasitas INTEGER NOT NULL
0075          CHECK (kapasitas > 0),
0076  
0077      status VARCHAR(20) NOT NULL DEFAULT 'Kosong'
0078          CHECK (status IN ('Kosong', 'Terisi', 'Dipesan'))
0079  );
0080  
0081  
0082  -- =========================================================
0083  -- 5. TABEL PESANAN
0084  -- =========================================================
0085  
0086  CREATE TABLE IF NOT EXISTS pesanan (
0087      id SERIAL PRIMARY KEY,
0088  
0089      kode_pesanan VARCHAR(20) NOT NULL UNIQUE,
0090  
0091      pelanggan_id INTEGER,
0092  
0093      meja_id INTEGER,
0094  
0095      tanggal_pesanan TIMESTAMP NOT NULL
0096          DEFAULT CURRENT_TIMESTAMP,
0097  
0098      status VARCHAR(30) NOT NULL DEFAULT 'Proses',
0099  
0100      total NUMERIC(12,2) NOT NULL DEFAULT 0,
0101  
0102      CONSTRAINT fk_pesanan_pelanggan
0103          FOREIGN KEY (pelanggan_id)
0104          REFERENCES pelanggan(id)
0105          ON UPDATE CASCADE
0106          ON DELETE SET NULL,
0107  
0108      CONSTRAINT fk_pesanan_meja
0109          FOREIGN KEY (meja_id)
0110          REFERENCES meja(id)
0111          ON UPDATE CASCADE
0112          ON DELETE SET NULL
0113  );
0114  
0115  
0116  -- =========================================================
0117  -- 6. TABEL DETAIL PESANAN
0118  -- =========================================================
0119  
0120  CREATE TABLE IF NOT EXISTS detail_pesanan (
0121      id SERIAL PRIMARY KEY,
0122  
0123      pesanan_id INTEGER NOT NULL,
0124  
0125      menu_id INTEGER NOT NULL,
0126  
0127      jumlah INTEGER NOT NULL
0128          CHECK (jumlah > 0),
0129  
0130      harga NUMERIC(12,2) NOT NULL
0131          CHECK (harga >= 0),
0132  
0133      subtotal NUMERIC(12,2) NOT NULL
0134          CHECK (subtotal >= 0),
0135  
0136      CONSTRAINT fk_detail_pesanan
0137          FOREIGN KEY (pesanan_id)
0138          REFERENCES pesanan(id)
0139          ON DELETE CASCADE,
0140  
0141      CONSTRAINT fk_detail_menu
0142          FOREIGN KEY (menu_id)
0143          REFERENCES menu(id)
0144          ON DELETE RESTRICT
0145  );
0146  
0147  
0148  -- =========================================================
0149  -- 7. TABEL PEMBAYARAN
0150  -- =========================================================
0151  
0152  CREATE TABLE IF NOT EXISTS pembayaran (
0153      id SERIAL PRIMARY KEY,
0154  
0155      pesanan_id INTEGER NOT NULL UNIQUE,
0156  
0157      tanggal_bayar TIMESTAMP NOT NULL
0158          DEFAULT CURRENT_TIMESTAMP,
0159  
0160      total_bayar NUMERIC(12,2) NOT NULL
0161          CHECK (total_bayar >= 0),
0162  
0163      metode_pembayaran VARCHAR(30) NOT NULL
0164          CHECK (
0165              metode_pembayaran IN (
0166                  'Cash',
0167                  'QRIS',
0168                  'Debit',
0169                  'E-Wallet'
0170              )
0171          ),
0172  
0173      status VARCHAR(20) NOT NULL DEFAULT 'Lunas'
0174          CHECK (
0175              status IN (
0176                  'Lunas',
0177                  'Belum Lunas'
0178              )
0179          ),
0180  
0181      CONSTRAINT fk_pembayaran_pesanan
0182          FOREIGN KEY (pesanan_id)
0183          REFERENCES pesanan(id)
0184          ON DELETE CASCADE
0185  );
0186  
0187  
0188  
0189  -- =========================================================
0190  -- 8. TABEL USERS
0191  -- =========================================================
0192  
0193  CREATE TABLE IF NOT EXISTS users (
0194      id SERIAL PRIMARY KEY,
0195  
0196      nama VARCHAR(150) NOT NULL,
0197  
0198      username VARCHAR(50) NOT NULL UNIQUE,
0199  
0200      password VARCHAR(255) NOT NULL,
0201  
0202      role VARCHAR(20) NOT NULL DEFAULT 'petugas'
0203          CHECK (role IN ('admin', 'petugas')),
0204  
0205      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
0206  );
0207  
0208  
0209  -- =========================================================
0210  -- DATA AWAL KATEGORI
0211  -- =========================================================
0212  
0213  INSERT INTO kategori (nama_kategori)
0214  VALUES
0215      ('Kopi'),
0216      ('Non-Kopi'),
0217      ('Makanan'),
0218      ('Snack'),
0219      ('Dessert')
0220  ON CONFLICT (nama_kategori) DO NOTHING;
0221  
0222  
0223  -- =========================================================
0224  -- DATA AWAL MEJA
0225  -- =========================================================
0226  
0227  INSERT INTO meja (
0228      nomor_meja,
0229      kapasitas,
0230      status
0231  )
0232  VALUES
0233      ('M01', 2, 'Kosong'),
0234      ('M02', 2, 'Kosong'),
0235      ('M03', 4, 'Kosong'),
0236      ('M04', 4, 'Kosong'),
0237      ('M05', 6, 'Kosong')
0238  ON CONFLICT (nomor_meja) DO NOTHING;
0239  
0240  
0241  -- =========================================================
0242  -- SELESAI
0243  -- =========================================================
```
### Konsep yang harus bisa dijelaskan
database constraint, referential integrity, uniqueness constraint.
### Pertanyaan dosen yang mungkin muncul
- Apa peran foreign key di tabel ini?
- Kenapa aturan ini ditegakkan di database juga?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/sql/02_users.sql`
**Ukuran:** 14 baris. **Peran:** bagian aplikasi yang menangani halaman/CRUD terkait.

### Kode asli (line-numbered)
```text
0001  -- =========================================================
0002  -- JOBSHEET 10
0003  -- TABEL USERS
0004  -- =========================================================
0005  
0006  CREATE TABLE IF NOT EXISTS users (
0007      id SERIAL PRIMARY KEY,
0008      nama VARCHAR(150) NOT NULL,
0009      username VARCHAR(50) NOT NULL UNIQUE,
0010      password VARCHAR(255) NOT NULL,
0011      role VARCHAR(20) NOT NULL DEFAULT 'petugas'
0012          CHECK (role IN ('admin', 'petugas')),
0013      created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
0014  );
```
### Konsep yang harus bisa dijelaskan
database constraint, uniqueness constraint.
### Pertanyaan dosen yang mungkin muncul
- Kenapa aturan ini ditegakkan di database juga?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**

## `Jobsheet12/sql/03_integrasi_transaksi.sql`
**Ukuran:** 32 baris. **Peran:** index tambahan dan catatan integrasi transaksi JS12.

### Kode asli (line-numbered)
```text
0001  -- =========================================================
0002  -- JOBSHEET 12 - INTEGRASI TRANSAKSI CAFE_NAJWA
0003  -- PostgreSQL
0004  --
0005  -- File ini tidak membuat database baru.
0006  -- Jalankan setelah database.sql dan 02_users.sql.
0007  -- =========================================================
0008  
0009  -- Index untuk mempercepat relasi dan pencarian transaksi.
0010  CREATE INDEX IF NOT EXISTS idx_pesanan_pelanggan
0011      ON pesanan (pelanggan_id);
0012  
0013  CREATE INDEX IF NOT EXISTS idx_pesanan_meja
0014      ON pesanan (meja_id);
0015  
0016  CREATE INDEX IF NOT EXISTS idx_detail_pesanan_pesanan
0017      ON detail_pesanan (pesanan_id);
0018  
0019  CREATE INDEX IF NOT EXISTS idx_detail_pesanan_menu
0020      ON detail_pesanan (menu_id);
0021  
0022  CREATE INDEX IF NOT EXISTS idx_pembayaran_pesanan
0023      ON pembayaran (pesanan_id);
0024  
0025  -- =========================================================
0026  -- INTEGRASI JS12
0027  --
0028  -- 1. Pesanan terhubung dengan pelanggan + meja.
0029  -- 2. Detail pesanan terhubung dengan menu.
0030  -- 3. Pembayaran terhubung dengan pesanan.
0031  -- 4. Stok menu dikendalikan oleh proses pesanan.
0032  -- =========================================================
```
### Pertanyaan dosen yang mungkin muncul
- Apa fungsi file ini dan apa akibatnya jika file ini tidak dipanggil?
### Pola jawaban
**Fungsi → alasan → bukti di kode → dampak jika diubah.**
