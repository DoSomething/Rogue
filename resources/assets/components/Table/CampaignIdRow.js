import React from 'react';
import { map } from 'lodash';
import PropTypes from 'prop-types';

class CampaignIdRow extends React.Component {
  constructor() {
    super();

    this.createCampaignIdRow = this.createCampaignIdRow.bind(this);
  }

  createCampaignIdRow(campaign) {
    const row = [
      {
        url: null,
        title: campaign.id,
      },
      {
        url: `/campaign-ids/${campaign.id}`,
        title: campaign.internal_title,
      },
      {
        url: null,
        title: campaign.cause,
      },
      {
        url: campaign.impact_doc,
        title: 'Read',
      },
      {
        url: null,
        title: new Date(campaign.start_date).toString(),
      },
      {
        url: null,
        title: campaign.end_date ? new Date(campaign.end_date).toString() : '-',
      },
    ];

    return row;
  }

  render() {
    const content = this.createCampaignIdRow(this.props.data);

    return (
      <tr className="table__row">
        {content.map((cell, index) => {
          {
            if (cell.url) {
              return (
                <td className="table__cell" key={index}>
                  <a href={cell.url}>{cell.title}</a>
                </td>
              );
            }

            return (
              <td className="table__cell" key={index}>
                {cell.title}
              </td>
            );
          }
        })}
      </tr>
    );
  }
}

CampaignIdRow.PropTypes = {
  data: PropTypes.object,
};

CampaignIdRow.defaultProps = {
  data: null,
};

export default CampaignIdRow;
