import { JSX } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { Helmet } from 'react-helmet-async';

import IndexBackground from '../../views/ui/layout/IndexBackground';

import "./IntroduceUniPage.scss";

const IntroduceUniPage = (): JSX.Element => {
    const navigate = useNavigate();
    const { type } = useParams();

    let name:string = "";

    switch(type){
        case 'dai-hoc':
            name = "đại học";
            break;
        case 'cao-dang':
            name = "cao đẳng";
            break;
        case 'lien-thong':
            name = "lien-thong";
            break;
        default:
            navigate("/");
    }

  return (
      <div>
      <Helmet>
        <title>Web tuyển sinh - Giới thiệu hệ {name}</title>
      </Helmet>
      <IndexBackground>
          <div>{name}</div>
      </IndexBackground>
    </div>
    );
};

export default IntroduceUniPage;
