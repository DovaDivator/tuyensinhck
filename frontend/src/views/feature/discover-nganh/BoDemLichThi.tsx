import React, { useState, useEffect, JSX } from "react";
import { useNavigate } from "react-router-dom";
import { useInView } from "react-intersection-observer";

import { jsxEleProps } from "../../../types/jsxElementInterfaces";

import Button from "../../ui/input/Button";
import Countdown from "../../ui/components/Countdown";

import "./BoDemLichThi.scss";

interface BoDemLichThiProps extends jsxEleProps {
    type?: string;
}

const BoDemLichThi = ({className = "", type = ""}: BoDemLichThiProps): JSX.Element => {
  const navigate = useNavigate();

  const FORM_LIST = [
    "Kỳ thi hiện tại chưa mở, thông tin mới nhất chúng tôi sẽ cập nhật sau!",
    "Thời gian mở kỳ thi sẽ điễn ra sau:",
    "Kỳ thi đã mở, hãy tham gia ngay!",
    "Kỳ thi đã kết thúc, cảm ơn bạn đã quan tâm!",
  ]

  const BUTTON_CLASS_PHASE = ["hide", "start", "loop"];
  const [buttonAnimation, setButtonAnimation] = useState(BUTTON_CLASS_PHASE[0]);

  const { ref, inView } = useInView({
    triggerOnce: true, 
    threshold: 0.3,
  });

  useEffect(() => {
    if (inView) {
      const startLoopAnimation = () => {
        setTimeout(() => {
          setButtonAnimation(BUTTON_CLASS_PHASE[2]);

          setTimeout(() => {
            setButtonAnimation("");
            setTimeout(startLoopAnimation, 5000);
          }, 1250);
        }, 5000);
      };

      setButtonAnimation(BUTTON_CLASS_PHASE[1]);
      startLoopAnimation();

      return () => {};
    }
  }, [inView]);

    return (
        <section className={`bodemlichthi ${className}`} ref={ref}>
            <div className="blur"></div>
            <div>
                <h2 className="bodemlichthi__title">Thời gian mở kỳ thi</h2>
                <p className="bodemlichthi__description">{FORM_LIST[0]}</p>
                <Countdown/>
                <Button
                    text="Đăng ký ngay!"
                    className={buttonAnimation}
                    onClick={() => navigate("/dang-ky")}
                />
            </div>
        </section>
    );
}

export default BoDemLichThi;