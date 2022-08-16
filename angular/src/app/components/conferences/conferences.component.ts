import { Component, OnInit } from '@angular/core';
import { Conference, ConferenceType} from "../../models/conference";
import {ConferenceService} from "../../services/conference.service";

@Component({
  selector: 'app-conferences',
  templateUrl: './conferences.component.html',
  styleUrls: ['./conferences.component.sass']
})
export class ConferencesComponent implements OnInit {

  conferences: ConferenceType[] = [];
  selectedConference?: ConferenceType;

  constructor(private conferenceService: ConferenceService) {
  }

  getConferences() : void {
    this.conferenceService.getConferenceList().subscribe(conferences => this.conferences = conferences);
  }

  ngOnInit(): void {
   this.getConferences();
  }

}
