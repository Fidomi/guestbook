import { Component, OnInit } from '@angular/core';
import { ConferenceType} from "../../models/conference";
import {ConferenceService} from "../../services/conference.service";
import { faEye } from '@fortawesome/free-regular-svg-icons';
import {Icon, IconDefinition} from "@fortawesome/fontawesome-svg-core";

@Component({
  selector: 'app-conferences',
  templateUrl: './conferences.component.html',
  styleUrls: ['./conferences.component.sass']
})
export class ConferencesComponent implements OnInit {

  conferences: ConferenceType[] = [];
  faEye : IconDefinition = faEye;
  constructor(private conferenceService: ConferenceService) {
  }

  getConferences() : void {
    this.conferenceService.getConferenceList().subscribe(conferences => this.conferences = conferences);
  }

  ngOnInit(): void {
   this.getConferences();
  }

}
