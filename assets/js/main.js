document.addEventListener('DOMContentLoaded', function() {
    // Form handling
    const form = document.getElementById('registrationForm');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        try {
            const formData = new FormData(form);
            const response = await fetch('api/register.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if(data.success) {
                alert('Đăng ký thành công!');
                form.reset();
                window.location.href = `payment.php?id=${data.registration_id}`;
            } else {
                alert(data.message);
            }
        } catch(err) {
            console.error(err);
            alert('Có lỗi xảy ra, vui lòng thử lại!');
        }
    });

    // Video lazy loading
    const videos = document.querySelectorAll('.video-wrapper iframe');
    const videoObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                const iframe = entry.target;
                iframe.src = iframe.dataset.src;
                videoObserver.unobserve(iframe);
            }
        });
    });

    videos.forEach(video => videoObserver.observe(video));
});