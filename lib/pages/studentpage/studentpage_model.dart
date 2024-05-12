import '/backend/api_requests/api_calls.dart';
import '/flutter_flow/flutter_flow_util.dart';
import 'studentpage_widget.dart' show StudentpageWidget;
import 'package:flutter/material.dart';

class StudentpageModel extends FlutterFlowModel<StudentpageWidget> {
  ///  State fields for stateful widgets in this page.

  final unfocusNode = FocusNode();
  // Stores action output result for [Backend Call - API (pickup)] action in Button widget.
  ApiCallResponse? apiResultg4u;
  // Stores action output result for [Backend Call - API (stuid)] action in Button widget.
  ApiCallResponse? apiResultujn;
  // Stores action output result for [Backend Call - API (messagesG)] action in Button widget.
  ApiCallResponse? apiResult6bz;

  @override
  void initState(BuildContext context) {}

  @override
  void dispose() {
    unfocusNode.dispose();
  }
}
