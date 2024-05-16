import 'dart:convert';
import 'package:flutter/foundation.dart';

import '/flutter_flow/flutter_flow_util.dart';
import 'api_manager.dart';

export 'api_manager.dart' show ApiCallResponse;

const _kPrivateApiFunctionName = 'ffPrivateApiCall';

class RegistrationCall {
  static Future<ApiCallResponse> call({
    String? email = '',
  }) async {
    return ApiManager.instance.makeApiCall(
      callName: 'registration',
      apiUrl:
          'https://ragorr.dreamhosters.com/public/api/registration?email=$email',
      callType: ApiCallType.POST,
      headers: {},
      params: {},
      bodyType: BodyType.NONE,
      returnBody: true,
      encodeBodyUtf8: false,
      decodeUtf8: false,
      cache: false,
      alwaysAllowBody: false,
    );
  }

  static String? fathername(dynamic response) =>
      castToType<String>(getJsonField(
        response,
        r'''$.name.FatherName''',
      ));
  static List<int>? id(dynamic response) => (getJsonField(
        response,
        r'''$.data[:].id''',
        true,
      ) as List?)
          ?.withoutNulls
          .map((x) => castToType<int>(x))
          .withoutNulls
          .toList();
  static dynamic na(dynamic response) => getJsonField(
        response,
        r'''$.name''',
      );
  static List? da(dynamic response) => getJsonField(
        response,
        r'''$.data''',
        true,
      ) as List?;
  static String? fa(dynamic response) => castToType<String>(getJsonField(
        response,
        r'''$.data[:].FatherName''',
      ));
  static String? stu(dynamic response) => castToType<String>(getJsonField(
        response,
        r'''$.data[:].StudentName''',
      ));
}

class ChangeCall {
  static Future<ApiCallResponse> call({
    String? id = '',
    String? password = '',
  }) async {
    return ApiManager.instance.makeApiCall(
      callName: 'change',
      apiUrl:
          'https://ragorr.dreamhosters.com/public/api/change?id=$id&password=$password',
      callType: ApiCallType.POST,
      headers: {},
      params: {},
      bodyType: BodyType.JSON,
      returnBody: true,
      encodeBodyUtf8: false,
      decodeUtf8: false,
      cache: false,
      alwaysAllowBody: false,
    );
  }
}

class LoginCall {
  static Future<ApiCallResponse> call({
    String? email = '',
    String? password = '',
  }) async {
    return ApiManager.instance.makeApiCall(
      callName: 'login',
      apiUrl:
          'https://ragorr.dreamhosters.com/public/api/applogin?email=$email&password=$password',
      callType: ApiCallType.POST,
      headers: {},
      params: {},
      bodyType: BodyType.JSON,
      returnBody: true,
      encodeBodyUtf8: false,
      decodeUtf8: false,
      cache: false,
      alwaysAllowBody: false,
    );
  }

  static String? ms(dynamic response) => castToType<String>(getJsonField(
        response,
        r'''$.Error''',
      ));
  static int? id(dynamic response) => castToType<int>(getJsonField(
        response,
        r'''$[:].id''',
      ));
}

class StudentsCall {
  static Future<ApiCallResponse> call({
    String? id = '',
  }) async {
    return ApiManager.instance.makeApiCall(
      callName: 'students',
      apiUrl: 'https://ragorr.dreamhosters.com/public/api/students?id=$id',
      callType: ApiCallType.POST,
      headers: {},
      params: {},
      bodyType: BodyType.JSON,
      returnBody: true,
      encodeBodyUtf8: false,
      decodeUtf8: false,
      cache: false,
      alwaysAllowBody: false,
    );
  }

  static List<int>? id(dynamic response) => (getJsonField(
        response,
        r'''$[:].id''',
        true,
      ) as List?)
          ?.withoutNulls
          .map((x) => castToType<int>(x))
          .withoutNulls
          .toList();
  static List<String>? sn(dynamic response) => (getJsonField(
        response,
        r'''$[:].StudentName''',
        true,
      ) as List?)
          ?.withoutNulls
          .map((x) => castToType<String>(x))
          .withoutNulls
          .toList();
  static List<String>? sa(dynamic response) => (getJsonField(
        response,
        r'''$[:].StudentAge''',
        true,
      ) as List?)
          ?.withoutNulls
          .map((x) => castToType<String>(x))
          .withoutNulls
          .toList();
  static List<String>? bn(dynamic response) => (getJsonField(
        response,
        r'''$[:].Balance''',
        true,
      ) as List?)
          ?.withoutNulls
          .map((x) => castToType<String>(x))
          .withoutNulls
          .toList();
}

class PickupCall {
  static Future<ApiCallResponse> call({
    String? id = '',
    String? name = '',
    String? coordinates = '',
  }) async {
    return ApiManager.instance.makeApiCall(
      callName: 'pickup',
      apiUrl:
          'https://ragorr.dreamhosters.com/public/api/pickUp?id=$id&name=$name&coordinates=$coordinates',
      callType: ApiCallType.POST,
      headers: {},
      params: {},
      bodyType: BodyType.JSON,
      returnBody: true,
      encodeBodyUtf8: false,
      decodeUtf8: false,
      cache: false,
      alwaysAllowBody: false,
    );
  }
}

class StuidCall {
  static Future<ApiCallResponse> call({
    String? id = '',
    String? name = '',
  }) async {
    return ApiManager.instance.makeApiCall(
      callName: 'stuid',
      apiUrl:
          'https://ragorr.dreamhosters.com/public/api/stuid?id=$id&name=$name',
      callType: ApiCallType.POST,
      headers: {},
      params: {},
      bodyType: BodyType.JSON,
      returnBody: true,
      encodeBodyUtf8: false,
      decodeUtf8: false,
      cache: false,
      alwaysAllowBody: false,
    );
  }

  static dynamic stuid(dynamic response) => getJsonField(
        response,
        r'''$''',
      );
}

class ChargeCall {
  static Future<ApiCallResponse> call({
    String? id = '',
    String? amount = '',
  }) async {
    return ApiManager.instance.makeApiCall(
      callName: 'Charge',
      apiUrl:
          'https://ragorr.dreamhosters.com/public/api/Charge?id=$id&amount=$amount',
      callType: ApiCallType.POST,
      headers: {},
      params: {},
      bodyType: BodyType.JSON,
      returnBody: true,
      encodeBodyUtf8: false,
      decodeUtf8: false,
      cache: false,
      alwaysAllowBody: false,
    );
  }

  static String? res(dynamic response) => castToType<String>(getJsonField(
        response,
        r'''$''',
      ));
}

class TeacherRegisterCall {
  static Future<ApiCallResponse> call({
    String? email = '',
  }) async {
    return ApiManager.instance.makeApiCall(
      callName: 'Teacher register',
      apiUrl:
          'https://ragorr.dreamhosters.com/public/api/signup?email=$email',
      callType: ApiCallType.POST,
      headers: {},
      params: {},
      bodyType: BodyType.JSON,
      returnBody: true,
      encodeBodyUtf8: false,
      decodeUtf8: false,
      cache: false,
      alwaysAllowBody: false,
    );
  }

  static dynamic name(dynamic response) => getJsonField(
        response,
        r'''$.name''',
      );
  static String? nameo(dynamic response) => castToType<String>(getJsonField(
        response,
        r'''$.name.Name''',
      ));
  static int? id(dynamic response) => castToType<int>(getJsonField(
        response,
        r'''$.data[:].id''',
      ));
  static String? role(dynamic response) => castToType<String>(getJsonField(
        response,
        r'''$.data[:].role''',
      ));
}

class TeachChangeCall {
  static Future<ApiCallResponse> call({
    String? id = '',
    String? password = '',
  }) async {
    return ApiManager.instance.makeApiCall(
      callName: 'teach change',
      apiUrl:
          'https://ragorr.dreamhosters.com/public/api/changeT?id=$id&password=$password',
      callType: ApiCallType.POST,
      headers: {},
      params: {},
      bodyType: BodyType.JSON,
      returnBody: true,
      encodeBodyUtf8: false,
      decodeUtf8: false,
      cache: false,
      alwaysAllowBody: false,
    );
  }

  static String? pass(dynamic response) => castToType<String>(getJsonField(
        response,
        r'''$.ok''',
      ));
}

class TeacherLoginCall {
  static Future<ApiCallResponse> call({
    String? email = '',
    String? password = '',
  }) async {
    return ApiManager.instance.makeApiCall(
      callName: 'teacher login',
      apiUrl:
          'https://ragorr.dreamhosters.com/public/api/apploginT?email=$email&password=$password',
      callType: ApiCallType.POST,
      headers: {},
      params: {},
      bodyType: BodyType.JSON,
      returnBody: true,
      encodeBodyUtf8: false,
      decodeUtf8: false,
      cache: false,
      alwaysAllowBody: false,
    );
  }

  static int? id(dynamic response) => castToType<int>(getJsonField(
        response,
        r'''$[:].id''',
      ));
  static String? err(dynamic response) => castToType<String>(getJsonField(
        response,
        r'''$.Error''',
      ));
}

class StudenlateCall {
  static Future<ApiCallResponse> call() async {
    return ApiManager.instance.makeApiCall(
      callName: 'studenlate',
      apiUrl: 'https://ragorr.dreamhosters.com/public/api/studentCallApp1',
      callType: ApiCallType.GET,
      headers: {},
      params: {},
      returnBody: true,
      encodeBodyUtf8: false,
      decodeUtf8: false,
      cache: false,
      alwaysAllowBody: false,
    );
  }

  static List<String>? names(dynamic response) => (getJsonField(
        response,
        r'''$[:].NAME''',
        true,
      ) as List?)
          ?.withoutNulls
          .map((x) => castToType<String>(x))
          .withoutNulls
          .toList();
  static List<String>? dates(dynamic response) => (getJsonField(
        response,
        r'''$[:].updated_at''',
        true,
      ) as List?)
          ?.withoutNulls
          .map((x) => castToType<String>(x))
          .withoutNulls
          .toList();
  static List<int>? ids(dynamic response) => (getJsonField(
        response,
        r'''$[:].id''',
        true,
      ) as List?)
          ?.withoutNulls
          .map((x) => castToType<int>(x))
          .withoutNulls
          .toList();
  static List<String>? timein(dynamic response) => (getJsonField(
        response,
        r'''$[:].TimeIn''',
        true,
      ) as List?)
          ?.withoutNulls
          .map((x) => castToType<String>(x))
          .withoutNulls
          .toList();
  static List<String>? studentid(dynamic response) => (getJsonField(
        response,
        r'''$[:].StudentID''',
        true,
      ) as List?)
          ?.withoutNulls
          .map((x) => castToType<String>(x))
          .withoutNulls
          .toList();
}

class StudentsintimeCall {
  static Future<ApiCallResponse> call() async {
    return ApiManager.instance.makeApiCall(
      callName: 'studentsintime',
      apiUrl: 'https://ragorr.dreamhosters.com/public/api/studentCallApp',
      callType: ApiCallType.GET,
      headers: {},
      params: {},
      returnBody: true,
      encodeBodyUtf8: false,
      decodeUtf8: false,
      cache: false,
      alwaysAllowBody: false,
    );
  }

  static int? ids(dynamic response) => castToType<int>(getJsonField(
        response,
        r'''$[:].id''',
      ));
  static String? studentsid(dynamic response) =>
      castToType<String>(getJsonField(
        response,
        r'''$[:].StudentID''',
      ));
  static String? timein(dynamic response) => castToType<String>(getJsonField(
        response,
        r'''$[:].TimeIn''',
      ));
  static List<String>? names(dynamic response) => (getJsonField(
        response,
        r'''$[:].NAME''',
        true,
      ) as List?)
          ?.withoutNulls
          .map((x) => castToType<String>(x))
          .withoutNulls
          .toList();
}

class AuthorizationCall {
  static Future<ApiCallResponse> call({
    String? name = '',
    String? email = '',
    String? studentName = '',
  }) async {
    return ApiManager.instance.makeApiCall(
      callName: 'authorization',
      apiUrl:
          'https://ragorr.dreamhosters.com/public/api/autho?Name=$name&Email=$email&StudentName=$studentName',
      callType: ApiCallType.POST,
      headers: {},
      params: {},
      bodyType: BodyType.JSON,
      returnBody: true,
      encodeBodyUtf8: false,
      decodeUtf8: false,
      cache: false,
      alwaysAllowBody: false,
    );
  }
}

class AuthREGCall {
  static Future<ApiCallResponse> call({
    String? email = '',
  }) async {
    return ApiManager.instance.makeApiCall(
      callName: 'authREG',
      apiUrl: 'https://ragorr.dreamhosters.com/public/api/reg?email=$email',
      callType: ApiCallType.POST,
      headers: {},
      params: {},
      bodyType: BodyType.JSON,
      returnBody: true,
      encodeBodyUtf8: false,
      decodeUtf8: false,
      cache: false,
      alwaysAllowBody: false,
    );
  }

  static List<int>? id(dynamic response) => (getJsonField(
        response,
        r'''$.data[:].id''',
        true,
      ) as List?)
          ?.withoutNulls
          .map((x) => castToType<int>(x))
          .withoutNulls
          .toList();
}

class AuthchangepaSSCall {
  static Future<ApiCallResponse> call({
    String? id = '',
    String? password = '',
  }) async {
    return ApiManager.instance.makeApiCall(
      callName: 'authchangepaSS',
      apiUrl:
          'https://ragorr.dreamhosters.com/public/api/authch?id=$id&password=$password',
      callType: ApiCallType.POST,
      headers: {},
      params: {},
      bodyType: BodyType.JSON,
      returnBody: true,
      encodeBodyUtf8: false,
      decodeUtf8: false,
      cache: false,
      alwaysAllowBody: false,
    );
  }

  static int? id(dynamic response) => castToType<int>(getJsonField(
        response,
        r'''$[:].id''',
      ));
  static String? sid(dynamic response) => castToType<String>(getJsonField(
        response,
        r'''$[:].StudentId''',
      ));
}

class AuthstudentsCall {
  static Future<ApiCallResponse> call({
    int? id,
  }) async {
    return ApiManager.instance.makeApiCall(
      callName: 'Authstudents',
      apiUrl:
          'https://ragorr.dreamhosters.com/public/api/authstudents?id=$id',
      callType: ApiCallType.POST,
      headers: {},
      params: {},
      bodyType: BodyType.JSON,
      returnBody: true,
      encodeBodyUtf8: false,
      decodeUtf8: false,
      cache: false,
      alwaysAllowBody: false,
    );
  }

  static List<String>? name(dynamic response) => (getJsonField(
        response,
        r'''$[:].StudentName''',
        true,
      ) as List?)
          ?.withoutNulls
          .map((x) => castToType<String>(x))
          .withoutNulls
          .toList();
}

class AuthlogCall {
  static Future<ApiCallResponse> call({
    String? email = '',
    String? password = '',
  }) async {
    return ApiManager.instance.makeApiCall(
      callName: 'authlog',
      apiUrl:
          'https://ragorr.dreamhosters.com/public/api/authlog?email=$email&password=$password',
      callType: ApiCallType.POST,
      headers: {},
      params: {},
      bodyType: BodyType.JSON,
      returnBody: true,
      encodeBodyUtf8: false,
      decodeUtf8: false,
      cache: false,
      alwaysAllowBody: false,
    );
  }

  static List<int>? id(dynamic response) => (getJsonField(
        response,
        r'''$[:].id''',
        true,
      ) as List?)
          ?.withoutNulls
          .map((x) => castToType<int>(x))
          .withoutNulls
          .toList();
  static String? studentid(dynamic response) => castToType<String>(getJsonField(
        response,
        r'''$[:].StudentId''',
      ));
  static String? err(dynamic response) => castToType<String>(getJsonField(
        response,
        r'''$.Error''',
      ));
}

class SendCall {
  static Future<ApiCallResponse> call({
    String? message = '',
    String? sender = '',
    String? receiver = '',
    String? direction = '',
  }) async {
    return ApiManager.instance.makeApiCall(
      callName: 'send',
      apiUrl:
          'https://ragorr.dreamhosters.com/public/api/message?message=$message&sender=$sender&receiver=$receiver&direction=$direction',
      callType: ApiCallType.POST,
      headers: {},
      params: {},
      bodyType: BodyType.JSON,
      returnBody: true,
      encodeBodyUtf8: false,
      decodeUtf8: false,
      cache: false,
      alwaysAllowBody: false,
    );
  }
}

class MessagesCall {
  static Future<ApiCallResponse> call({
    String? sender = '',
    String? receiver = '',
  }) async {
    return ApiManager.instance.makeApiCall(
      callName: 'messages',
      apiUrl:
          'https://ragorr.dreamhosters.com/public/pagedata?sender=$sender&receiver=$receiver',
      callType: ApiCallType.GET,
      headers: {},
      params: {},
      returnBody: true,
      encodeBodyUtf8: false,
      decodeUtf8: false,
      cache: false,
      alwaysAllowBody: false,
    );
  }

  static List<String>? message(dynamic response) => (getJsonField(
        response,
        r'''$[:].message''',
        true,
      ) as List?)
          ?.withoutNulls
          .map((x) => castToType<String>(x))
          .withoutNulls
          .toList();
  static List<String>? sender(dynamic response) => (getJsonField(
        response,
        r'''$[:].sender''',
        true,
      ) as List?)
          ?.withoutNulls
          .map((x) => castToType<String>(x))
          .withoutNulls
          .toList();
}

class MessagesGCall {
  static Future<ApiCallResponse> call({
    String? sender = '',
    String? receiver = '',
  }) async {
    return ApiManager.instance.makeApiCall(
      callName: 'messagesG',
      apiUrl:
          'https://ragorr.dreamhosters.com/public/pagedata1?sender=$sender&receiver=$receiver',
      callType: ApiCallType.GET,
      headers: {},
      params: {},
      returnBody: true,
      encodeBodyUtf8: false,
      decodeUtf8: false,
      cache: false,
      alwaysAllowBody: false,
    );
  }

  static List<String>? sender(dynamic response) => (getJsonField(
        response,
        r'''$[:].sender''',
        true,
      ) as List?)
          ?.withoutNulls
          .map((x) => castToType<String>(x))
          .withoutNulls
          .toList();
  static List<String>? teacher(dynamic response) => (getJsonField(
        response,
        r'''$[:].receiver''',
        true,
      ) as List?)
          ?.withoutNulls
          .map((x) => castToType<String>(x))
          .withoutNulls
          .toList();
  static List<String>? message(dynamic response) => (getJsonField(
        response,
        r'''$[:].message''',
        true,
      ) as List?)
          ?.withoutNulls
          .map((x) => castToType<String>(x))
          .withoutNulls
          .toList();
}

class ApiPagingParams {
  int nextPageNumber = 0;
  int numItems = 0;
  dynamic lastResponse;

  ApiPagingParams({
    required this.nextPageNumber,
    required this.numItems,
    required this.lastResponse,
  });

  @override
  String toString() =>
      'PagingParams(nextPageNumber: $nextPageNumber, numItems: $numItems, lastResponse: $lastResponse,)';
}

String _serializeList(List? list) {
  list ??= <String>[];
  try {
    return json.encode(list);
  } catch (_) {
    if (kDebugMode) {
      print("List serialization failed. Returning empty list.");
    }
    return '[]';
  }
}

String _serializeJson(dynamic jsonVar, [bool isList = false]) {
  jsonVar ??= (isList ? [] : {});
  try {
    return json.encode(jsonVar);
  } catch (_) {
    if (kDebugMode) {
      print("Json serialization failed. Returning empty json.");
    }
    return isList ? '[]' : '{}';
  }
}
