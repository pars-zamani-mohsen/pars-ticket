document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.querySelector('.border-dashed');
    if (!dropZone) return; // اگر المان پیدا نشد

    const fileInput = dropZone.querySelector('input[type="file"]');
    if (!fileInput) return; // اگر input پیدا نشد

    // جلوگیری از رفتار پیش‌فرض
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        document.body.addEventListener(eventName, preventDefaults, false);
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // افکت‌های بصری
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            dropZone.classList.add('border-indigo-500', 'bg-indigo-50');
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
        });
    });

    // مدیریت رها کردن فایل
    dropZone.addEventListener('drop', function(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        // تبدیل FileList به آرایه و اضافه کردن به input
        const fileArray = Array.from(files);
        const dataTransfer = new DataTransfer();

        fileArray.forEach(file => {
            dataTransfer.items.add(file);
        });

        fileInput.files = dataTransfer.files;
        updateFileList(fileInput);
    });
});

// تابع نمایش لیست فایل‌ها
function updateFileList(input) {
    const fileList = document.getElementById('fileList');
    if (!fileList) return;

    fileList.innerHTML = '';

    Array.from(input.files).forEach(file => {
        const fileSize = (file.size / 1024).toFixed(1);
        const div = document.createElement('div');
        div.textContent = `${file.name} (${fileSize} KB)`;
        fileList.appendChild(div);
    });
}
