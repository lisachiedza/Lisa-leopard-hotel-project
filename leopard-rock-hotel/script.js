function handleForm(formId, url) {
  const form = document.getElementById(formId);
  if (!form) return;
  const box = document.getElementById('message');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();                      
    box.className = 'message';
    try {
      const res = await fetch(url, { method: 'POST', body: new FormData(form) });
      const data = await res.json();
      box.textContent = data.message;
      box.className = 'message show ' + (data.success ? 'ok' : 'error');
      if (data.success) form.reset();
    } catch (err) {
      box.textContent = 'Server error. Run the site through PHP (see README).';
      box.className = 'message show error';
    }
  });
}


const checkIn = document.getElementById('check_in');
const checkOut = document.getElementById('check_out');
if (checkIn && checkOut) {
  const today = new Date().toISOString().split('T')[0];
  checkIn.min = checkOut.min = today;
  checkIn.addEventListener('change', () => { checkOut.min = checkIn.value; });
}

handleForm('bookingForm', 'booking.php');
handleForm('contactForm', 'contact.php');
