import {JSX} from "react";
import { Helmet } from "react-helmet-async";
import IndexBackground from "../../views/ui/layout/IndexBackground";
import IntroduceSection from "../../views/feature/introduce/IntroduceSection";
import "./IntroducePage.scss";

const IntroducePage = (): JSX.Element => {
    return (
        <div>
      <Helmet>
        <title>Web tuyển sinh - Giới thiệu trường</title>
      </Helmet>
      <IndexBackground>
          <IntroduceSection/>
      </IndexBackground>
    </div>
    );
};

export default IntroducePage;