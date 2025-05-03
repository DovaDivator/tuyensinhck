import React, {useState, useEffect} from "react";
import { useInView } from "react-intersection-observer";
import Card from "../../ui/tag/Card";

import './OutstadingStuSection.scss';

const students = [
  {
    name: "Nguyễn Văn An",
    class: "Công nghệ thông tin",
    des: "Trường học là nơi lưu giữ biết bao kỷ niệm tuổi học trò. Mỗi ngày đến lớp, tôi được gặp thầy cô thân thương, bạn bè gắn bó và học thêm nhiều điều mới lạ. Những tiết học sôi nổi, tiếng cười vui vẻ nơi sân trường khiến tôi cảm thấy ấm áp và hạnh phúc. Trường không chỉ dạy kiến thức mà còn dạy tôi cách sống, cách yêu thương và chia sẻ. Mái trường thân yêu như một ngôi nhà thứ hai, nơi tôi lớn lên từng ngày. Dù sau này có đi đâu, tôi vẫn luôn nhớ về nơi này. ala ala ala ala ala ala ala ala ala ala ala ala ala ala ala ala ala ala ala alax`",
    avatar: "https://via.placeholder.com/150"
  },
  {
    name: "Trần Thị Bình",
    class: "Quản trị kinh doanh",
    des: "Trường học là nơi lưu giữ biết bao kỷ niệm tuổi học trò. Mỗi ngày đến lớp, tôi được gặp thầy cô thân thương, bạn bè gắn bó và học thêm nhiều điều mới lạ. Những tiết học sôi nổi, tiếng cười vui vẻ nơi sân trường khiến tôi cảm thấy ấm áp và hạnh phúc. Trường không chỉ dạy kiến thức mà còn dạy tôi cách sống, cách yêu thương và chia sẻ. Mái trường thân yêu như một ngôi nhà thứ hai, nơi tôi lớn lên từng ngày. Dù sau này có đi đâu, tôi vẫn luôn nhớ về nơi này.",
    avatar: "https://via.placeholder.com/150"
  },
  {
    name: "Lê Minh Châu",
    class: "Khoa học dữ liệu",
    des: "Trường học là nơi lưu giữ biết bao kỷ niệm tuổi học trò. Mỗi ngày đến lớp, tôi được gặp thầy cô thân thương, bạn bè gắn bó và học thêm nhiều điều mới lạ. Những tiết học sôi nổi, tiếng cười vui vẻ nơi sân trường khiến tôi cảm thấy ấm áp và hạnh phúc. Trường không chỉ dạy kiến thức mà còn dạy tôi cách sống, cách yêu thương và chia sẻ. Mái trường thân yêu như một ngôi nhà thứ hai, nơi tôi lớn lên từng ngày. Dù sau này có đi đâu, tôi vẫn luôn nhớ về nơi này.",
    avatar: "https://via.placeholder.com/150"
  }
];

const OutstadingStuSection = () =>{
  const { ref, inView } = useInView({
    triggerOnce: true,
    threshold: 0.3,
  });
  const [animationClass, setAnimationClass] = useState("hide");

  useEffect(() => {
    if (inView) {
        setAnimationClass("start");
    }
  }, [inView]);

    return (
        <section className="student-section">
        <h2>Học Sinh Tiêu Biểu</h2>
        <div ref={ref} className={`student-container ${animationClass}`}>
        {students.map((student, index) => (
          <Card key={index} className="student-card">
            <img src={student.avatar} />
            <h3>{student.name}</h3>
            <p>{student.class}</p>
            <p>{student.des}</p>
          </Card>
        ))}
        </div>
      </section>
    );
}

export default OutstadingStuSection;