
<div id="proof-container">
</div>
<script>
function addProofEntry() {
    // Lấy container
    var container = document.getElementById('proof-container');

    // Tạo một div mới cho mục bằng chứng
    var newEntry = document.createElement('div');
    newEntry.classList.add('proof-entry');
    
    // Nội dung HTML cho div mới
    newEntry.innerHTML = `

        <select name="proof_type[]" required>
            <option value="" disabled selected>Chọn loại bằng chứng</option>
            <option value="english_certificate">Chứng chỉ tiếng Anh</option>
            <option value="international_award">Giải quốc tế</option>
            <option value="hsg_exam">Thi HSG</option>
            <option value="priority_subject">Đối tượng ưu tiên</option>
        </select>

        <select name="proof_detail[]" required>
            <option value="1" selected>1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>

        <input type="file" name="imgs_bonus[]" accept="image/*" required>
            <button type="button" onclick="removeProofEntry(this)" style="margin-bottom: 10px; width:fit-content">Xóa chỉ mục</button>
        <div style="height: 1px; background-color: grey;"></div>
    `;

    // Thêm mục mới vào container
    container.appendChild(newEntry);
}
</script>