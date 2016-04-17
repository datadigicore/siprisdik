# siprisdik

<h3>Database</h3>	
cara import database lewat terminal :

mysql -u username -p database_name < file.sql

<h4>informasi kolom</h4>

tabel rabfull dan rabview telah dihapus sebagian kolom yang tidak terpakai
Untuk rabfull : 
<ul>
<li>Tabel rabfull setiap row pasti memakai value sebagai jumlahnya berapa</li>
<li>Kolom selain value dipakai untu yang ada perjalanan saja</li>
<li>Untuk uang_harian dan biaya_akom agak sedikit berbeda. Kalau akunnya itu perjalanan, maka 2 hal ini masuk ke dalam kolomnya sendiri sesuai nama. Tetapi kalau dia bukan perjalanan, berarti dia berdiri sendiri dan masuknya ke kolom value.</li>
</ul>

<hr>
<h3>Untuk Clean Usulan Dan Realisasi</h3>

<i>UPDATE rkakl_full SET usulan = null, realisasi = null</i>
