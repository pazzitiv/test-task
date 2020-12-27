import { Component, OnInit } from '@angular/core';
import {StateService} from "../../services/state/state.service";

@Component({
  selector: 'app-content',
  templateUrl: './content.component.html',
  styleUrls: ['./content.component.scss']
})
export class ContentComponent implements OnInit {

  constructor(private state: StateService) { }

  ngOnInit(): void {
  }

}
