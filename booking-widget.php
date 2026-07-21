<?php
require_once __DIR__ . "/../../config/config.php";

$cities = [];

$sql = "SELECT id, city_name
        FROM cities
        WHERE is_active=1
        ORDER BY city_name";

$result = $conn->query($sql);

if($result){
    while($row=$result->fetch_assoc()){
        $cities[]=$row;
    }
}
?>

<section class="booking-section" id="booking">

<div class="container">

<div class="booking-box">

<div class="booking-header">

<h2>Book Your Journey</h2>

<p>
Search buses, trains, metro, cabs and EV charging stations instantly.
</p>

</div>

<div class="booking-tabs">

<button class="tab active">🚌 Bus</button>

<button class="tab">🚆 Train</button>

<button class="tab">🚇 Metro</button>

<button class="tab">🚖 Cab</button>

<button class="tab">⚡ EV</button>

</div>

<form action="booking/search.php" method="POST">

<input type="hidden" name="service" id="selectedService" value="bus">

<div class="booking-grid">

<div class="input-group">

<label>From</label>

<select name="from_city" required>

<option value="">Select Departure</option>

<?php foreach($cities as $city){ ?>

<option value="<?= $city['id']; ?>">

<?= htmlspecialchars($city['city_name']); ?>

</option>

<?php } ?>

</select>

</div>

<div class="input-group">

<label>To</label>

<select name="to_city" required>

<option value="">Select Destination</option>

<?php foreach($cities as $city){ ?>

<option value="<?= $city['id']; ?>">

<?= htmlspecialchars($city['city_name']); ?>

</option>

<?php } ?>

</select>

</div>

<div class="input-group">

<label>Journey Date</label>

<input
type="date"
name="journey_date"
required>

</div>

<div class="input-group">

<label>Passengers</label>

<select name="passengers">

<option>1</option>

<option>2</option>

<option>3</option>

<option>4</option>

<option>5</option>

<option>6</option>

</select>

</div>

<div class="input-group">

<label>Class</label>

<select name="travel_class">

<option>Economy</option>

<option>Premium</option>

<option>Business</option>

<option>Luxury</option>

</select>

</div>

<div class="input-group">

<label>&nbsp;</label>

<button
type="submit"
class="search-btn">

<i class="fa-solid fa-magnifying-glass"></i>

Search

</button>

</div>

</div>

</form>

</div>

</div>

</section>