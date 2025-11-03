document.addEventListener('DOMContentLoaded', function(event) {

    document.getElementById('flip-card-btn-turn-to-back').style.visibility = 'visible';
    document.getElementById('flip-card-btn-turn-to-front').style.visibility = 'visible';
  
    document.getElementById('flip-card-btn-turn-to-back').onclick = function() {
    document.getElementById('flip-card').classList.toggle('do-flip');
    };
});

function copyToClipboard() {
    const labelToCopy = document.getElementById('labelToCopy');
    const textToCopy = labelToCopy.innerText;
    
    const tempInput = document.createElement('input');
    tempInput.value = textToCopy;
    document.body.appendChild(tempInput);
    
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);

  }

  function copyToClipboard2() {
    const labelToCopy2 = document.getElementById('labelToCopy2');
    const textToCopy = labelToCopy2.innerText;
    
    const tempInput = document.createElement('input');
    tempInput.value = textToCopy;
    document.body.appendChild(tempInput);
    
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);

  }
  