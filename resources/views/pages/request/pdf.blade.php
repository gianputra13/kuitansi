<style>

body{
  /* background-color: aqua; */
}

.header{
  margin-top: 150px
}
.center{
  text-align: center
}
.underline {
  border-bottom: 6px solid;
  letter-spacing: 4px
}
.table-font{
  font-size: 17px;
  font-family: Arial;
  font-weight: 270
}
.table-font td {
  padding: 12px 0;
  width: 350px;
}
.table-font td:nth-child(1) {
  width: 200px;
}
.table-font td:nth-child(2) {
  width: 10px;
}

.watermark {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 350px;
  z-index: -1;
  opacity: 0.2;
}

</style>

<body>
  <h1 class="center header underline"></h1>
  <img class="watermark" src="{{ $base64Image }}" alt="Signature">
  <br>
  <table class="table-font">
    <tr>
      <td>Telah diterima dari</td>
      <td>:</td>
      <td>{{ $data['received_from'] }}</td>
    </tr>
    <tr>
      <td>Banyaknya Uang</td>
      <td>:</td>
      <td>{{ $data['payment_number_text'] }}</td>
    </tr>
    <tr>
      <td>Untuk Pembayaran</td>
      <td>:</td>
      <td>{{ $data['for_payment'] }}</td>
    </tr>
    <tr>
      <td>Tipe Pembayaran</td>
      <td>:</td>
      <td>{{ $data['type_payment'] }}</td>
    </tr>
    <tr>
      <td>Total</td>
      <td>:</td>
      <td>{{ $data['payment_number'] }}</td>
    </tr>
  </table>
</body>

