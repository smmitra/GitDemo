<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>10 Digit Mobile No</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        
        .form-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
        }

        
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

       
        .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        
        .input-field {
            width: 100%;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

       
        .input-field:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

      
        .input-label {
            position: absolute;
            top: 15px;
            left: 15px;
            color: #999;
            pointer-events: none;
            transition: all 0.3s ease;
        }
        
        
        .input-field:focus + .input-label,
        .input-field:not(:placeholder-shown) + .input-label {
            top: -10px;
            left: 10px;
            font-size: 12px;
            color: #007bff;
            background-color: #fff;
            padding: 0 5px;
        }

       
        .submit-btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 8px;
            background-color: #007bff;
            color: #ffffff;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

      
        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>FORM</h2>
        <form id="mainForm" onsubmit="return false;">
        <div class="input-group">
            <input type="text" id="numberInput" class="input-field" placeholder=" " pattern="[0-9]{10}" maxlength="10" title="Please Enter 10 Digit Mobile Number" required>
            <label for="numberInput" class="input-label">Please Enter Your Valid Phone Number</label>
        </div>

        <div id="otpSection" style="display:none;">
            <div class="input-group">
                <input type="text" id="otpInput" class="input-field" placeholder=" " maxlength="6" required>
                <label for="otpInput" class="input-label">Enter OTP</label>
            </div>
        </div>

        <button id="sendBtn" class="submit-btn">Save</button>

        <div id="info" class="small"></div>
    </form>
    </div>
    
    <!-- Modal -->
<div id="backdrop" class="modal-backdrop" role="dialog" aria-hidden="true">
    <div class="modal" role="document">
        <h3 id="modalTitle">Result</h3>
        <div id="modalBody">
            <div class="row"><strong>Card</strong><span id="m_card"></span></div>
            <div class="row"><strong>Phone</strong><span id="m_phone"></span></div>
            <div class="row"><strong>Result</strong><span id="m_result"></span></div>
            <div class="row"><strong>Prize</strong><span id="m_prize"></span></div>
        </div>
        <div class="actions">
            <button id="waOpen" class="btn btn-primary">Open WhatsApp (Admin)</button>
            <button id="closeModal" class="btn btn-secondary">Close</button>
        </div>
    </div>
</div>

<script>
(function(){
    const params = new URLSearchParams(window.location.search);
    const card = params.get('code') || ''; // QR provided card value
    if (!card) {
        document.getElementById('info').innerText = 'Invalid card code in URL.';
        document.getElementById('sendBtn').disabled = true;
    }

    const sendBtn = document.getElementById('sendBtn');
    const infoEl = document.getElementById('info');
    const otpSection = document.getElementById('otpSection');
    const otpInput = document.getElementById('otpInput');
    const numberInput = document.getElementById('numberInput');

    let adminWaLink = null; // will be set after verification

    sendBtn.addEventListener('click', async function () {
        // if OTP section hidden -> first step: send OTP
        if (otpSection.style.display === 'none') {
            // validate phone
            const phone = numberInput.value.trim();
            if (!/^\d{10}$/.test(phone)) { infoEl.innerText = 'Enter valid 10-digit phone.'; return; }
            sendBtn.disabled = true;
            infoEl.innerText = 'Requesting OTP...';
            try {
                const data = new FormData();
                data.append('phone', phone);
                data.append('card', card);
                const resp = await fetch('send_otp.php', { method: 'POST', body: data });
                const json = await resp.json();
                if (json.success) {
                    otpSection.style.display = 'block';
                    infoEl.innerText = 'OTP sent (testing). Enter OTP below.';
                    // show testing OTP if backend returned it
                    if (json.otp_for_testing) infoEl.innerText += ' (Testing OTP: ' + json.otp_for_testing + ')';
                    sendBtn.innerText = 'Verify OTP';
                } else {
                    infoEl.innerText = 'Error: ' + (json.message || 'Failed to send OTP.');
                }
            } catch (err) {
                infoEl.innerText = 'Network error.';
            } finally {
                sendBtn.disabled = false;
            }
            return;
        }

        // second step: verify OTP
        const otp = otpInput.value.trim();
        const phone = numberInput.value.trim();
        if (!/^\d{4,6}$/.test(otp)) { infoEl.innerText = 'Enter OTP.'; return; }
        sendBtn.disabled = true;
        infoEl.innerText = 'Verifying OTP...';
        try {
            const data = new FormData();
            data.append('phone', phone);
            data.append('card', card);
            data.append('otp', otp);
            const resp = await fetch('verify_otp.php', { method: 'POST', body: data });
            const json = await resp.json();
            if (json.success) {
                infoEl.innerText = 'OTP verified: ' + (json.display_message || '');
                // show modal with details
                document.getElementById('m_card').innerText = json.card || card;
                document.getElementById('m_phone').innerText = json.phone || phone;
                document.getElementById('m_result').innerText = (json.is_winner ? 'Winner' : 'Not winner');
                document.getElementById('m_prize').innerText = json.prize_amount ? '₹' + json.prize_amount : '-';
                adminWaLink = json.admin_whatsapp_link || null;
                openModal();
            } else {
                infoEl.innerText = 'Error: ' + (json.message || 'Verification failed.');
            }
        } catch (err) {
            infoEl.innerText = 'Network error during verification.';
        } finally {
            sendBtn.disabled = false;
        }
    });

    // modal controls
    const backdrop = document.getElementById('backdrop');
    document.getElementById('closeModal').addEventListener('click', closeModal);
    document.getElementById('waOpen').addEventListener('click', function () {
        if (!adminWaLink) {
            alert('WhatsApp link not available.');
            return;
        }
        // open wa.me link in new tab
        window.open(adminWaLink, '_blank');
    });

    function openModal() { backdrop.style.display = 'flex'; backdrop.setAttribute('aria-hidden','false'); }
    function closeModal() { backdrop.style.display = 'none'; backdrop.setAttribute('aria-hidden','true'); }

})();
</script>

</body>
</html>
