import { Component, OnInit, Input } from '@angular/core';
import {ConferenceType} from "../../models/conference";
import {ActivatedRoute} from "@angular/router";
import {ConferenceService} from "../../services/conference.service";

@Component({
  selector: 'app-conference-details',
  templateUrl: './conference-details.component.html',
  styleUrls: ['./conference-details.component.sass']
})
export class ConferenceDetailsComponent implements OnInit {
  conference?: ConferenceType;
  constructor(private route:ActivatedRoute, private conferenceService: ConferenceService) {}

  getConference(id:number) : void {
    this.conferenceService.getConferenceDetails(id).subscribe(conference => this.conference = conference);
  }

  ngOnInit(): void {
    const routeParams = this.route.snapshot.paramMap;
    const conferenceIdFromRoute = Number( routeParams.get('conferenceId'));
    this.getConference(conferenceIdFromRoute);
  }

}
