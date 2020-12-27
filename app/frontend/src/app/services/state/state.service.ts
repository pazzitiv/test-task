import { Injectable } from '@angular/core';
import {BehaviorSubject} from "rxjs";
import {Auth} from "../../interfaces/auth";

export const defaultAuth: Auth = {
  user: null,
  token: ''
}

@Injectable({
  providedIn: 'root'
})

export class StateService {

  /**
   * Авторизация
   * @private
   */
  private _auth:BehaviorSubject<Auth> = new BehaviorSubject(defaultAuth)
  auth = this._auth.asObservable();

  /**
   * Отбражение/скрытие Прелоадера
   */
  private _loading = new BehaviorSubject(true);
  loading = this._loading.asObservable();

  /**
   * Отбражение/скрытие Сайдбара
   */
  private SidebarState = new BehaviorSubject(true);
  showSidebar = this.SidebarState.asObservable();

  /**
   * Тайтл в печеньках
   */
  private breadcrumb = new BehaviorSubject('');
  breadcrumbObserver = this.breadcrumb.asObservable();

  constructor() {
  }

  authorize(state:Auth)
  {
    this._auth.next(Object.assign({...defaultAuth}, {...state}));
  }

  /**
   * Метод смены вида Лоадера
   * @param state
   */
  changeLoading(state:boolean) {
    this._loading.next(state);
  }

  /**
   * Метод смены вида Сайдбара
   * @param state
   */
  changeSidebarState(state:boolean) {
    this.SidebarState.next(state);
  }

  /**
   * Смена тайтла в печеньках
   * @param state
   */
  changeBreadcrumbState(state:string) {
    this.breadcrumb.next(state);
  }
}
