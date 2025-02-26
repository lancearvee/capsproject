<?php
include('../adminpage/medical_cert_header.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../userLogin/landing.php');
    exit();
}
?>

<style>
    .preload {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

</style>


<style> 
  .custom-title {
    font-family: 'Organon', sans-serif;
    color: lightblue;
    font-weight: 300;
    -webkit-text-stroke: 1px black; /* Black letter border */
    text-stroke: 1px black; /* For other browsers */
  }

  @font-face {
    font-family: 'Ahmed Outline';
    src: url('/path/to/ahmed-outline.ttf') format('truetype');
  }

  .ahmed-outline-title {
    font-family: 'Ahmed Outline', sans-serif;
    color: white;
    font-size: 32px;
    -webkit-text-stroke: 2px black; /* Black border */
    text-stroke: 2px black; /* For other browsers */
  }

  .header-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .logo {
    max-width: 100px; /* Adjust size as needed */
  }

  .title-container {
    text-align: right;
    flex-grow: 1;
  }

  .logo {
    width: 250px !important;
    height: 200px !important;
    max-width: none; /* Override any max-width setting */
  }
    @media print {
    footer {
      display: none;
    }
    .header-container {
        padding-top: 100px;
    }
    #certifyBtn {
      display: none !important;
    }
  }

</style>

<div id="preload" class="preload">
    <div class="spinner"></div>
</div>




  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
        <div class="card-header header-container" >
            <img src="../assets/medical_cert_logo.png" alt="Logo" class="logo">
            <div class="title-container">
              <h4 style="font-family: 'Poppins', sans-serif; color: maroon; margin-bottom: 10px; font-size: 35px;">
                  Uzziel R. de Mesa, MD, FPCP, DPSEDM
              </h4>

              <h4 class="custom-title" style ="font-size: 30px;">INTERNAL MEDICINE - ENDOCRINOLOGY</h4>
              <h4 class="ahmed-outline-title" style ="font-size: 25px;">
                thyroid &nbsp; diabetes &nbsp; obesity &nbsp; bone &nbsp; adrenal &nbsp; pituitary &nbsp; hormones
              </h4>
            </div>
          </div>
          <div class="card-body">
              <div style="margin-bottom: 10px; font-weight: bold; font-size: 25px; display: flex; justify-content: space-between; align-items: center;">
                  <span>NAME: <input type="text" id="fullname" class="underline editable" style="border: none; border-bottom: 1px solid black; outline: none;">
                  </span>
                  <span style="flex-grow: 1; text-align: center;">AGE/SEX: <span id="age-sex" class="editable underline">_____________</span></span>
                  <span style="text-align: right;">
                      DATE: 
                      <input type="date" id="dateInput" class="underline" style="border: none; border-bottom: 1px solid black; outline: none;">
                      <span id="formattedDate" class="editable underline" style="text-decoration: underline;"></span>
                  </span>
              </div>
          </div>
          
          <div style="border: 1px solid black; padding: 15px; text-align: justify; font-size: 25px;">
            <div style="text-align: center; font-size: 30px; font-weight: bold; margin-bottom: 15px;">
                MEDICAL CLEARANCE
            </div>
              <span class="editable underline">________________</span><br>
              To whom it may concern:<br><br>
              This is to certify that <span class="editable underline">________________</span>, a 
              <span class="editable underline">___</span> year old <span class="editable underline">____</span>, consulted 
              this clinic on <span class="editable underline">________________</span>, for his/her 
              <span class="editable underline">___________________</span>, and was diagnosed to have 
              <span class="editable underline">__________________________</span> for which he/she was advised 
              <span class="editable underline">________________________</span> and follow-up consult 
              <span class="editable underline">______________________</span>.<br><br>

              This certification was issued upon the request of the patient for whatever medical purpose this may serve.<br><br>
              Should you have queries, kindly contact the undersigned on the information given below.<br><br>

              Respectfully, <br><br>

              <span class="editable underline">________________</span><br>
              UZZIEL R. DE MESA, MD, FPCP, DPSEDM<br>
              INTERNIST -ENDOCRINOLOGIST<br>
              LICENSE NO. 116105   PTR 217508<br>
              PHILHEALTH No. 1202-1740972-2<br>
              uzzieldemesa@gmail.com
          </div>
          <br><br>
          <div style="font-size: 20px; text-align: center; font-weight: bold;">
              ALABANG MEDICAL CENTER, MARY MEDIATRIX MEDICAL CENTER-LIPA CITY, MEDICAL CENTER WESTERN BATANGAS, 
              LUNA GOCO MEDICAL CENTER, MEDICAL MISSION GROUP HOSPITAL, MA ESTRELLA GENERAL HOSPITAL, 
              PINAMALAYAN DOCTORS HOSPITAL
          </div>
            <button id="certifyBtn" class="btn btn-success" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000;">
                Issue Certification
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
document.getElementById("certifyBtn").addEventListener("click", function () {
    Swal.fire({
        title: 'Confirm Payment',
        html: `
            <form id="certForm">
                <input type="text" id="fullname" class="swal2-input" placeholder="Enter Full Name" required>
                <input type="number" id="med_cert_bill" class="swal2-input" placeholder="Enter Price" required>
                <input type="number" id="payment" class="swal2-input" placeholder="Enter Payment" required>
                <input type="text" id="change" class="swal2-input" placeholder="Change" readonly>
            </form>`,
        showCancelButton: true,
        confirmButtonText: 'Confirm',
        cancelButtonText: 'Cancel',
        didOpen: () => {
            const priceInput = document.getElementById('med_cert_bill');
            const paymentInput = document.getElementById('payment');
            const changeInput = document.getElementById('change');

            function calculateChange() {
                const price = parseFloat(priceInput.value) || 0;
                const payment = parseFloat(paymentInput.value) || 0;
                const change = payment - price;
                changeInput.value = change >= 0 ? change.toFixed(2) : "Insufficient Payment";
            }

            priceInput.addEventListener('input', calculateChange);
            paymentInput.addEventListener('input', calculateChange);
        },
        preConfirm: () => {
            const fullname = document.getElementById('fullname').value;  // Capture fullname
            const price = parseFloat(document.getElementById('med_cert_bill').value);
            const payment = parseFloat(document.getElementById('payment').value);
            const change = payment - price;
            
            const dateInput = document.getElementById('dateInput') ? document.getElementById('dateInput').value : '';
            const formattedDate = dateInput ? new Date(dateInput).toISOString().split('T')[0] : ''; 

            if (!fullname || !price || !payment || payment < price) {
                Swal.showValidationMessage('Full name and payment must be filled, and payment must be equal to or greater than the price');
                return false;
            }

            return { fullname, price, payment, change, formattedDate };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const { fullname, price, payment, change, formattedDate } = result.value;

            const form = document.createElement("form");
            form.method = "POST";
            form.action = "../backendAdmin/med_cert_payment.php"; 

            form.innerHTML = `
                <input type="hidden" name="fullname" value="${fullname}">
                <input type="hidden" name="med_cert_bill" value="${price}">
                <input type="hidden" name="payment" value="${payment}">
                <input type="hidden" name="change" value="${change}">
                <input type="hidden" name="date" value="${formattedDate}">`; 

            document.body.appendChild(form);
            form.submit();
        }
    });
});

</script>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    function makeEditable(element) {
        element.addEventListener('click', function () {
            const currentText = this.textContent.trim();

            const input = document.createElement('input');
            input.type = 'text';
            input.value = currentText;

            this.replaceWith(input);

            input.focus();

            input.addEventListener('blur', function () {
                const newSpan = document.createElement('span');
                newSpan.className = 'editable underline';
                newSpan.textContent = this.value || '________________';
                newSpan.style.textDecoration = 'underline';

                input.replaceWith(newSpan);

                makeEditable(newSpan);
            });

            input.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    this.blur();
                }
            });
        });
    }

    const editableElements = document.querySelectorAll('.editable.underline');
    editableElements.forEach(element => {
        makeEditable(element);
    });

    // Date formatting functionality
    const dateInput = document.getElementById('dateInput');
    const formattedDateSpan = document.getElementById('formattedDate');

    dateInput.addEventListener('change', formatDate);
    dateInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            formatDate();
        }
    });

    function formatDate() {
        const dateValue = dateInput.value;
        if (dateValue) {
            const dateObj = new Date(dateValue);
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            formattedDateSpan.textContent = dateObj.toLocaleDateString('en-US', options);
            formattedDateSpan.style.textDecoration = 'underline'; // Add underline
            dateInput.style.display = 'none';
            formattedDateSpan.style.display = 'inline';
        }
    }

    formattedDateSpan.addEventListener('click', function () {
        dateInput.style.display = 'inline';
        formattedDateSpan.style.display = 'none';
        dateInput.focus();
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const successMessage = sessionStorage.getItem('successMessage');
        if (successMessage) {
            alertify.set('notifier', 'position', 'top-right');
            alertify.success(successMessage);

            sessionStorage.removeItem('successMessage');
        }
    });
</script>

<script>
    window.addEventListener('load', function() {
    document.getElementById('preload').style.display = 'none';
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
  
  <!-- Add Organon Sans font CDN -->
  <link href="https://fonts.googleapis.com/css2?family=Organon:wght@300&display=swap" rel="stylesheet">
<?php
include('../adminpage/footer.php');
?>