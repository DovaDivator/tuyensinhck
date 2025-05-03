import React, { useEffect } from "react";
import { useInView } from "react-intersection-observer";
import Card from "../../ui/tag/Card";
import "./KeyInformation.scss";

const termsData = [
  {
    title: "Ngành học đa dạng",
    description: "Chọn từ hơn 50 ngành học thuộc các lĩnh vực Công nghệ, Kinh tế, Y học...",
  },
  {
    title: "Học bổng hấp dẫn",
    description: "Cơ hội nhận học bổng lên đến 100% học phí cho sinh viên xuất sắc.",
  },
  {
    title: "Hỗ trợ 24/7",
    description: "Đội ngũ tư vấn luôn sẵn sàng giải đáp mọi thắc mắc của bạn.",
  },
];

const KeyInformation = () => {
  const { ref, inView } = useInView({
    triggerOnce: true,
    threshold: 0.3,
  });

  useEffect(() => {
    if (inView) {
      const startAnimation = () => {
        const items = document.querySelectorAll(".key-information__list__item");
        items.forEach((item, index) => {
          setTimeout(() => {
            item.classList.remove("hide");
            item.classList.add("start");
          }, index*500);
        });
      };

      startAnimation();
    }
  }, [inView]);

  return (
    <div className="key-information" ref={ref}>
      <div className="key-information__list">
        {termsData.map((item, index) => (
          <Card key={index} className="key-information__list__item hide">
            <h4 className="key-information__list__item-title">{item.title}</h4>
            <p className="key-information__list__item-description">{item.description}</p>
          </Card>
        ))}
      </div>
    </div>
  );
};

export default KeyInformation;