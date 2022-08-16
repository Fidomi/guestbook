export interface ConferenceType {
  id: number;
  name: string;
  year: string;
  city: string;
  isInternational: boolean;
}

export class Conference {
  id: number;
  name: string;
  year: string;
  city: string;
  isInternational: boolean;

  constructor(conference : ConferenceType) {
    this.id = conference.id;
    this.name = conference.name;
    this.year = conference.year;
    this.city = conference.city;
    this.isInternational = conference.isInternational;
  }
}
