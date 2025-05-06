<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('includes/head.php'); ?>
    <title>Green Points Calculator App</title>
</head>

<body>

<!-- ✅ Navbar include -->
<?php include('includes/nav.php'); ?>

<!-- ✅ Concise UNESCO Affiliation Section -->
<div class="container my-5">
    <div class="row align-items-center">
        <!-- Text Column -->
        <div class="col-md-6 mb-4">
            <div class="bg-white p-4 rounded shadow-sm h-100">
                <h2 class="mb-3">Aligned with UNESCO Values</h2>
                <h5>Our Sustainability Focus</h5>
                <p>
                    Sustain Energy supports a sustainable future by encouraging businesses to act responsibly across three key areas:
                </p>

                <div class="mb-3">
                    <h5>🌿 Environmental</h5>
                    <p>
                        We help companies track and reduce carbon emissions by promoting renewable energy use.
                    </p>
                </div>

                <div class="mb-3">
                    <h5>🤝 Social</h5>
                    <p>
                        Our platform rewards transparency and ethical practices to foster stakeholder trust.
                    </p>
                </div>

                <div>
                    <h5>📈 Economic</h5>
                    <p>
                        Our certification system supports growth by connecting companies with eco-conscious partners.
                    </p>
                </div>

                <div>
                <h5>Where Can I Find Out More?</h5>
                    <p>
                        To learn more, you can visit 
                        <a href="https://sdgs.un.org/goals">UNESCO's 17 Sustainability goals site</a>.
                    </p>
                </div>
            </div>
        </div>

        <!-- Image Column -->
        <div class="col-md-6 mb-4">
            <img src="images/sustainability-banner.jpg" alt="Sustainability Concept" class="img-fluid rounded shadow">
        </div>
    </div>
</div>

<div class="container my-5">
  <div class="bg-white p-4 rounded shadow-sm" style="max-height: 500px; overflow-y: auto;">
    <h2 class="mb-3">Green Points Calculator</h2>
    <p>Please tick the box that best represents your company’s practice in each area.</p>

    <form action="calculator_results.php" method="POST">

<!-- 1. Carbon Emissions Reduction -->
<div class="mb-4">
  <label class="form-label"><strong>1. Carbon Emissions Reduction</strong></label><br>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="carbon_emissions" value="positive" onclick="onlyOne(this)">
    <label class="form-check-label">🟢 Positive – Regular, measurable reductions</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="carbon_emissions" value="neutral" onclick="onlyOne(this)">
    <label class="form-check-label">🟡 Neutral – Some plans in place</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="carbon_emissions" value="negative" onclick="onlyOne(this)">
    <label class="form-check-label">🔴 Negative – No efforts or rising emissions</label>
  </div>
</div>

<!-- 2. Renewable Energy Usage -->
<div class="mb-4">
  <label class="form-label"><strong>2. Renewable Energy Usage</strong></label><br>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="renewable_energy" value="positive" onclick="onlyOne(this)">
    <label class="form-check-label">🟢 Positive – High percentage from renewables</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="renewable_energy" value="neutral" onclick="onlyOne(this)">
    <label class="form-check-label">🟡 Neutral – Partial renewable use</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="renewable_energy" value="negative" onclick="onlyOne(this)">
    <label class="form-check-label">🔴 Negative – Mostly fossil fuels</label>
  </div>
</div>

<!-- 3. Waste Reduction -->
<div class="mb-4">
  <label class="form-label"><strong>3. Waste Reduction</strong></label><br>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="waste_reduction" value="positive" onclick="onlyOne(this)">
    <label class="form-check-label">🟢 Positive – High recycling and minimal waste</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="waste_reduction" value="neutral" onclick="onlyOne(this)">
    <label class="form-check-label">🟡 Neutral – Some waste reduction initiatives</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="waste_reduction" value="negative" onclick="onlyOne(this)">
    <label class="form-check-label">🔴 Negative – Little to no waste management</label>
  </div>
</div>

<!-- 4. Water Conservation -->
<div class="mb-4">
  <label class="form-label"><strong>4. Water Conservation</strong></label><br>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="water_conservation" value="positive" onclick="onlyOne(this)">
    <label class="form-check-label">🟢 Positive – Actively conserves and monitors use</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="water_conservation" value="neutral" onclick="onlyOne(this)">
    <label class="form-check-label">🟡 Neutral – Limited water-saving practices</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="water_conservation" value="negative" onclick="onlyOne(this)">
    <label class="form-check-label">🔴 Negative – High consumption, no conservation</label>
  </div>
</div>

<!-- 5. Sustainable Supply Chain -->
<div class="mb-4">
  <label class="form-label"><strong>5. Sustainable Supply Chain</strong></label><br>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="supply_chain" value="positive" onclick="onlyOne(this)">
    <label class="form-check-label">🟢 Positive – Fully transparent and sustainable</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="supply_chain" value="neutral" onclick="onlyOne(this)">
    <label class="form-check-label">🟡 Neutral – Some supplier oversight</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="supply_chain" value="negative" onclick="onlyOne(this)">
    <label class="form-check-label">🔴 Negative – No regard for supplier sustainability</label>
  </div>
</div>

<!-- 6. Energy-Efficient Infrastructure -->
<div class="mb-4">
  <label class="form-label"><strong>6. Energy-Efficient Infrastructure</strong></label><br>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="infrastructure" value="positive" onclick="onlyOne(this)">
    <label class="form-check-label">🟢 Positive – Green-certified or optimized facilities</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="infrastructure" value="neutral" onclick="onlyOne(this)">
    <label class="form-check-label">🟡 Neutral – Some upgrades, not fully efficient</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="infrastructure" value="negative" onclick="onlyOne(this)">
    <label class="form-check-label">🔴 Negative – Outdated and inefficient systems</label>
  </div>
</div>

<!-- 7. Eco-friendly Products/Services -->
<div class="mb-4">
  <label class="form-label"><strong>7. Eco-friendly Products/Services</strong></label><br>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="products" value="positive" onclick="onlyOne(this)">
    <label class="form-check-label">🟢 Positive – Majority of offerings are green</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="products" value="neutral" onclick="onlyOne(this)">
    <label class="form-check-label">🟡 Neutral – Some eco-friendly options</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="products" value="negative" onclick="onlyOne(this)">
    <label class="form-check-label">🔴 Negative – No sustainable products</label>
  </div>
</div>

<!-- 8. Transportation Sustainability -->
<div class="mb-4">
  <label class="form-label"><strong>8. Transportation Sustainability</strong></label><br>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="transportation" value="positive" onclick="onlyOne(this)">
    <label class="form-check-label">🟢 Positive – Low-emission or electric fleet</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="transportation" value="neutral" onclick="onlyOne(this)">
    <label class="form-check-label">🟡 Neutral – Mixed practices</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="transportation" value="negative" onclick="onlyOne(this)">
    <label class="form-check-label">🔴 Negative – High carbon logistics</label>
  </div>
</div>

<!-- 9. Sustainable Packaging -->
<div class="mb-4">
  <label class="form-label"><strong>9. Sustainable Packaging</strong></label><br>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="packaging" value="positive" onclick="onlyOne(this)">
    <label class="form-check-label">🟢 Positive – Fully recyclable/biodegradable</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="packaging" value="neutral" onclick="onlyOne(this)">
    <label class="form-check-label">🟡 Neutral – Mixed or partial efforts</label>
  </div>
  <div class="form-check">
  <input class="form-check-input" type="checkbox" name="certifications" value="negative" onclick="onlyOne(this)">
    <label class="form-check-label">🔴 Negative – No recognized certifications or awards</label>
  </div>
</div>

<!-- 10. Green Certifications & Awards -->
<div class="mb-4">
  <label class="form-label"><strong>10. Green Certifications & Awards</strong></label><br>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="certifications" value="positive" onclick="onlyOne(this)">
    <label class="form-check-label">🟢 Positive – Multiple certifications or awards</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="certifications" value="neutral" onclick="onlyOne(this)">
    <label class="form-check-label">🟡 Neutral – Some certifications, working toward more</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" name="certifications" value="negative" onclick="onlyOne(this)">
    <label class="form-check-label">🔴 Negative – No recognized certifications or awards</label>
  </div>
</div>

      <!-- ✅ Add more questions here using the same format (name="...") -->

      <button type="submit" class="btn btn-success">Submit</button>
    </form>
  </div>
</div>

<script>
function onlyOne(checkbox) {
  const checkboxes = document.getElementsByName(checkbox.name);
  checkboxes.forEach((item) => {
    if (item !== checkbox) item.checked = false;
  });
}
</script>


<!-- ✅ Footer include -->
<?php include('includes/footer.php'); ?>

<!-- ✅ Bootstrap JS Bundle (already included in head.php or can stay here) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
