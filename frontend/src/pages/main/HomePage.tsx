import {JSX} from "react";
import { Helmet } from "react-helmet-async";
import IndexBackground from "../../views/ui/layout/IndexBackground";
import HeroSection from "../../views/feature/home/HeroSection";
import KeyInfomation from "../../views/feature/home/KeyInformation";
import IntroduceSection from "../../views/feature/introduce/IntroduceSection";
import NewsSection from "../../views/feature/news/NewsSection";
import UniLevelSection from "../../views/feature/home/UniLevelSection";
import OutstadingStuSection from "../../views/feature/home/OutstadingStuSection";
import "./HomePage.scss";

const CLASS_PAGE = "home";

const HomePage = (): JSX.Element => {
    return (
        <div>
      <Helmet>
        <title>Web tuyển sinh - Trang chủ</title>
      </Helmet>
      <IndexBackground>
          <HeroSection/>
          <IntroduceSection className={CLASS_PAGE}/>
          <KeyInfomation/>
          <UniLevelSection/>
          <NewsSection/>
          <OutstadingStuSection/>
      </IndexBackground>
    </div>
    );
};

export default HomePage;