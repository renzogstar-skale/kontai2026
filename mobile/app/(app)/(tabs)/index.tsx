import React, { useState, useRef, useEffect } from 'react';
import { StyleSheet, Text, View, ScrollView, Pressable, Platform, Dimensions, Animated, Easing } from 'react-native';
import { MaterialCommunityIcons, Ionicons } from '@expo/vector-icons';
import { useSafeAreaInsets } from 'react-native-safe-area-context';
import { LinearGradient } from 'expo-linear-gradient';
import { useRouter, Link } from 'expo-router';

type ShiftState = 'upcoming' | 'active' | 'break' | 'completed';

export default function EmployeeHome() {
  const router = useRouter();
  const insets = useSafeAreaInsets();
  const scrollY = useRef(new Animated.Value(0)).current;
  const [shiftState, setShiftState] = useState<ShiftState>('upcoming');

  // Entrance animations
  const fadeAnim = useRef(new Animated.Value(0)).current;
  const slideAnim = useRef(new Animated.Value(20)).current;

  useEffect(() => {
    Animated.parallel([
      Animated.timing(fadeAnim, {
        toValue: 1,
        duration: 400,
        useNativeDriver: true,
        easing: Easing.out(Easing.cubic),
      }),
      Animated.timing(slideAnim, {
        toValue: 0,
        duration: 500,
        useNativeDriver: true,
        easing: Easing.out(Easing.cubic),
      })
    ]).start();
  }, []);

  const HEADER_MAX_HEIGHT = 120 + insets.top;
  const HEADER_MIN_HEIGHT = 60 + insets.top;
  const SCROLL_DISTANCE = HEADER_MAX_HEIGHT - HEADER_MIN_HEIGHT;

  const headerHeight = scrollY.interpolate({
    inputRange: [0, SCROLL_DISTANCE],
    outputRange: [HEADER_MAX_HEIGHT, HEADER_MIN_HEIGHT],
    extrapolate: 'clamp',
  });

  const largeTitleOpacity = scrollY.interpolate({
    inputRange: [0, SCROLL_DISTANCE / 2],
    outputRange: [1, 0],
    extrapolate: 'clamp',
  });

  const largeTitleTranslate = scrollY.interpolate({
    inputRange: [0, SCROLL_DISTANCE],
    outputRange: [0, -15],
    extrapolate: 'clamp',
  });

  const compactTitleOpacity = scrollY.interpolate({
    inputRange: [SCROLL_DISTANCE / 2, SCROLL_DISTANCE],
    outputRange: [0, 1],
    extrapolate: 'clamp',
  });

  const headerShadow = scrollY.interpolate({
    inputRange: [0, SCROLL_DISTANCE],
    outputRange: [0, 0.06],
    extrapolate: 'clamp',
  });

  const handleClockAction = () => {
    if (shiftState === 'upcoming') setShiftState('active');
    else if (shiftState === 'active') setShiftState('completed');
  };

  const handleBreakAction = () => {
    if (shiftState === 'active') setShiftState('break');
    else if (shiftState === 'break') setShiftState('active');
  };

  return (
    <View style={styles.container}>
      {/* Sticky App Bar */}
      <Animated.View style={[
        styles.appBar, 
        { 
          height: headerHeight,
          paddingTop: insets.top,
          shadowOpacity: headerShadow,
          elevation: scrollY.interpolate({ inputRange: [0, SCROLL_DISTANCE], outputRange: [0, 6] })
        }
      ]}>
        <View style={styles.appBarTop}>
          <Animated.View style={[styles.compactTitleWrapper, { opacity: compactTitleOpacity }]}>
            <Text style={styles.compactTitle}>Good evening, Renzo</Text>
          </Animated.View>
          <View style={styles.appBarRight}>
            <Pressable style={({pressed}) => [styles.iconButton, pressed && {opacity: 0.7}]}>
              <Ionicons name="notifications-outline" size={24} color="#171717" />
              <View style={styles.badge} />
            </Pressable>
            <View style={styles.avatarContainer}>
              <Text style={styles.avatarText}>RG</Text>
            </View>
          </View>
        </View>

        <Animated.View 
          style={[
            styles.largeTitleWrapper, 
            { 
              opacity: largeTitleOpacity,
              transform: [{ translateY: largeTitleTranslate }]
            }
          ]}
          pointerEvents="none"
        >
          <Text style={styles.greeting}>Good evening, Renzo</Text>
          <Text style={styles.subGreeting}>Here’s your workday</Text>
        </Animated.View>
      </Animated.View>

      <Animated.ScrollView 
        contentContainerStyle={[styles.scrollContent, { paddingTop: HEADER_MAX_HEIGHT + 16, paddingBottom: 120 }]}
        showsVerticalScrollIndicator={false}
        onScroll={Animated.event(
          [{ nativeEvent: { contentOffset: { y: scrollY } } }],
          { useNativeDriver: false }
        )}
        scrollEventThrottle={16}
      >
        <Animated.View style={{ opacity: fadeAnim, transform: [{ translateY: slideAnim }] }}>
          {/* TODAY Hero Card */}
          <View style={styles.heroCard}>
            <View style={styles.heroHeader}>
              <Text style={styles.heroTitle}>TODAY</Text>
              <View style={[
                styles.statusBadge, 
                shiftState === 'active' && styles.statusBadgeActive,
                shiftState === 'break' && styles.statusBadgeBreak,
                shiftState === 'completed' && styles.statusBadgeCompleted
              ]}>
                <View style={[
                  styles.statusDot, 
                  shiftState === 'active' && styles.statusDotActive,
                  shiftState === 'break' && styles.statusDotBreak,
                  shiftState === 'completed' && styles.statusDotCompleted
                ]} />
                <Text style={[
                  styles.statusText,
                  shiftState === 'active' && styles.statusTextActive,
                  shiftState === 'break' && styles.statusTextBreak,
                  shiftState === 'completed' && styles.statusTextCompleted
                ]}>
                  {shiftState === 'upcoming' ? 'Not clocked in' : 
                   shiftState === 'active' ? 'Clocked In' : 
                   shiftState === 'break' ? 'On Break' : 'Completed'}
                </Text>
              </View>
            </View>

            <View style={styles.shiftInfo}>
              <Text style={styles.shiftTime}>7:00 AM — 4:00 PM</Text>
              <Text style={styles.shiftRole}>Food & Consumables</Text>
              <Text style={styles.shiftLocation}>Store #1996</Text>
            </View>

            {/* Contextual Message */}
            <View style={styles.contextMessage}>
              <MaterialCommunityIcons 
                name={shiftState === 'upcoming' ? "clock-fast" : shiftState === 'active' ? "timer-outline" : shiftState === 'break' ? "coffee" : "check-circle"} 
                size={18} 
                color="#737373" 
              />
              <Text style={styles.contextText}>
                {shiftState === 'upcoming' ? 'Shift starts in 28 min' :
                 shiftState === 'active' ? '2h 14m worked • Next break at 11:00 AM' :
                 shiftState === 'break' ? 'On break since 11:00 AM' : 
                 'Shift completed at 4:05 PM'}
              </Text>
            </View>

            {/* Dynamic Actions */}
            {shiftState !== 'completed' && (
              <View style={styles.actionRow}>
                {shiftState === 'active' || shiftState === 'break' ? (
                  <View style={styles.splitActions}>
                    <Pressable 
                      onPress={handleBreakAction}
                      style={({ pressed }) => [styles.secondaryBtn, pressed && styles.btnPressed]}
                    >
                      <Text style={styles.secondaryBtnText}>
                        {shiftState === 'break' ? 'End Break' : 'Start Break'}
                      </Text>
                    </Pressable>
                    <Pressable 
                      onPress={handleClockAction}
                      style={({ pressed }) => [styles.primaryBtn, pressed && styles.btnPressed]}
                    >
                      <LinearGradient
                        colors={['#E6392F', '#FF6B21']}
                        start={{ x: 0, y: 0 }}
                        end={{ x: 1, y: 1 }}
                        style={styles.gradientBtn}
                      >
                        <Text style={styles.primaryBtnText}>Clock Out</Text>
                      </LinearGradient>
                    </Pressable>
                  </View>
                ) : (
                  <Pressable 
                    onPress={handleClockAction}
                    style={({ pressed }) => [styles.primaryBtnWrapper, pressed && styles.btnPressed]}
                  >
                    <LinearGradient
                      colors={['#E6392F', '#FF6B21', '#FFB020']}
                      start={{ x: 0, y: 0 }}
                      end={{ x: 1, y: 1 }}
                      style={styles.gradientBtnFull}
                    >
                      <Text style={styles.primaryBtnText}>Clock In</Text>
                    </LinearGradient>
                  </Pressable>
                )}
              </View>
            )}

            <View style={styles.shiftSummary}>
              <Text style={styles.summaryText}>9h scheduled • 1h break</Text>
            </View>

            {/* Timeline */}
            <View style={styles.timeline}>
              <View style={styles.timelineLabels}>
                <Text style={styles.timelineTime}>7 AM</Text>
                <Text style={styles.timelineTime}>11 AM</Text>
                <Text style={styles.timelineTime}>12 PM</Text>
                <Text style={styles.timelineTime}>4 PM</Text>
              </View>
              <View style={styles.timelineTrackContainer}>
                <View style={styles.timelineTrackBg} />
                <LinearGradient 
                  colors={['#E6392F', '#FF6B21']} 
                  start={{x: 0, y: 0}} 
                  end={{x: 1, y: 0}} 
                  style={[
                    styles.timelineTrackFill, 
                    { width: shiftState === 'upcoming' ? '0%' : shiftState === 'active' ? '30%' : shiftState === 'break' ? '45%' : '100%' }
                  ]} 
                />
                
                <View style={[styles.timelineNode, { left: '0%' }]} />
                <View style={[styles.timelineNode, styles.timelineNodeBreak, { left: '44%' }]} />
                <View style={[styles.timelineNode, styles.timelineNodeBreak, { left: '55%' }]} />
                <View style={[styles.timelineNode, { right: '0%' }]} />
              </View>
              <View style={styles.timelineLabelsBottom}>
                <Text style={styles.timelineLabel}>Start</Text>
                <Text style={[styles.timelineLabel, { marginLeft: 16 }]}>Break</Text>
                <Text style={styles.timelineLabel}></Text>
                <Text style={styles.timelineLabel}>End</Text>
              </View>
            </View>
          </View>

          {/* Today's Tasks Section (Compact Contextual) */}
          <View style={styles.section}>
            <View style={styles.sectionHeader}>
              <Text style={styles.sectionTitle}>TODAY'S TASKS</Text>
            </View>
            <View style={styles.tasksCard}>
              <Pressable style={({pressed}) => [styles.taskItem, pressed && {backgroundColor: '#FAFAFA'}]}>
                <MaterialCommunityIcons name="checkbox-blank-circle-outline" size={22} color="#A3A3A3" />
                <Text style={styles.taskText}>Complete morning temperature log</Text>
              </Pressable>
              <View style={styles.taskDivider} />
              <Pressable style={({pressed}) => [styles.taskItem, pressed && {backgroundColor: '#FAFAFA'}]}>
                <MaterialCommunityIcons name="checkbox-blank-circle-outline" size={22} color="#A3A3A3" />
                <Text style={styles.taskText}>Team huddle at 2:00 PM</Text>
              </Pressable>
            </View>
          </View>

          {/* Upcoming Shifts */}
          <View style={styles.section}>
            <View style={styles.sectionHeader}>
              <Text style={styles.sectionTitle}>UPCOMING</Text>
              <Link href="/schedule" asChild>
                <Pressable hitSlop={10}>
                  <Text style={styles.linkText}>View full schedule</Text>
                </Pressable>
              </Link>
            </View>
            
            <Pressable style={({pressed}) => [styles.upcomingCard, pressed && styles.cardPressed]}>
              <View style={[styles.accentLine, { backgroundColor: '#FF6B21' }]} />
              <View style={styles.upcomingContent}>
                <View style={styles.upcomingHeaderRow}>
                  <Text style={styles.upcomingDate}>Tomorrow</Text>
                  <View style={styles.confirmedBadge}>
                    <Text style={styles.confirmedText}>Confirmed</Text>
                  </View>
                </View>
                <Text style={styles.upcomingRole}>Stocking • 8:00 AM</Text>
              </View>
              <MaterialCommunityIcons name="chevron-right" size={20} color="#D4D4D4" style={styles.chevron} />
            </Pressable>

            <Pressable style={({pressed}) => [styles.upcomingCard, pressed && styles.cardPressed]}>
              <View style={[styles.accentLine, { backgroundColor: '#2E7D32' }]} />
              <View style={styles.upcomingContent}>
                <View style={styles.upcomingHeaderRow}>
                  <Text style={styles.upcomingDate}>Wed, Oct 17</Text>
                  <View style={styles.confirmedBadge}>
                    <Text style={styles.confirmedText}>Confirmed</Text>
                  </View>
                </View>
                <Text style={styles.upcomingRole}>Food & Consumables • 7:00 AM</Text>
              </View>
              <MaterialCommunityIcons name="chevron-right" size={20} color="#D4D4D4" style={styles.chevron} />
            </Pressable>
            
            <Pressable style={({pressed}) => [styles.upcomingCard, pressed && styles.cardPressed]}>
              <View style={[styles.accentLine, { backgroundColor: '#E6392F' }]} />
              <View style={styles.upcomingContent}>
                <View style={styles.upcomingHeaderRow}>
                  <Text style={styles.upcomingDate}>Thu, Oct 18</Text>
                  <View style={styles.conflictBadge}>
                    <Text style={styles.conflictText}>Action Required</Text>
                  </View>
                </View>
                <Text style={styles.upcomingRole}>Coverage • 12:00 PM</Text>
              </View>
              <MaterialCommunityIcons name="chevron-right" size={20} color="#D4D4D4" style={styles.chevron} />
            </Pressable>
          </View>

        </Animated.View>
      </Animated.ScrollView>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#F7F7F5',
  },
  appBar: {
    position: 'absolute',
    top: 0,
    left: 0,
    right: 0,
    backgroundColor: '#F7F7F5',
    zIndex: 10,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowRadius: 8,
  },
  appBarTop: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    paddingHorizontal: 20,
    height: 60,
  },
  compactTitleWrapper: {
    flex: 1,
    justifyContent: 'center',
  },
  compactTitle: {
    fontSize: 16,
    fontWeight: '700',
    color: '#171717',
  },
  appBarRight: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  iconButton: {
    width: 40,
    height: 40,
    borderRadius: 20,
    backgroundColor: '#FFFFFF',
    alignItems: 'center',
    justifyContent: 'center',
    marginRight: 12,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.05,
    shadowRadius: 4,
    elevation: 2,
  },
  badge: {
    position: 'absolute',
    top: 8,
    right: 10,
    width: 8,
    height: 8,
    borderRadius: 4,
    backgroundColor: '#E6392F',
    borderWidth: 1.5,
    borderColor: '#FFFFFF',
  },
  avatarContainer: {
    width: 40,
    height: 40,
    borderRadius: 20,
    backgroundColor: '#222222',
    alignItems: 'center',
    justifyContent: 'center',
  },
  avatarText: {
    color: '#FFFFFF',
    fontSize: 14,
    fontWeight: '600',
  },
  largeTitleWrapper: {
    position: 'absolute',
    bottom: 12,
    left: 20,
    right: 20,
  },
  greeting: {
    fontSize: 24,
    fontWeight: '800',
    color: '#171717',
    letterSpacing: -0.5,
  },
  subGreeting: {
    fontSize: 14,
    color: '#737373',
    marginTop: 4,
    fontWeight: '500',
  },
  scrollContent: {
    paddingHorizontal: 16,
  },
  
  heroCard: {
    backgroundColor: '#FFFFFF',
    borderRadius: 24,
    padding: 24,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 8 },
    shadowOpacity: 0.06,
    shadowRadius: 16,
    elevation: 4,
    marginBottom: 24,
  },
  heroHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 20,
  },
  heroTitle: {
    fontSize: 13,
    fontWeight: '700',
    color: '#737373',
    letterSpacing: 1,
  },
  statusBadge: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#F5F5F5',
    paddingHorizontal: 10,
    paddingVertical: 6,
    borderRadius: 12,
  },
  statusBadgeActive: {
    backgroundColor: '#E8F5E9',
  },
  statusBadgeBreak: {
    backgroundColor: '#FFF8E1',
  },
  statusBadgeCompleted: {
    backgroundColor: '#F5F5F5',
  },
  statusDot: {
    width: 6,
    height: 6,
    borderRadius: 3,
    backgroundColor: '#9E9E9E',
    marginRight: 6,
  },
  statusDotActive: {
    backgroundColor: '#2E7D32',
  },
  statusDotBreak: {
    backgroundColor: '#FFB020',
  },
  statusDotCompleted: {
    backgroundColor: '#9E9E9E',
  },
  statusText: {
    fontSize: 12,
    fontWeight: '700',
    color: '#737373',
  },
  statusTextActive: {
    color: '#2E7D32',
  },
  statusTextBreak: {
    color: '#F57C00',
  },
  statusTextCompleted: {
    color: '#737373',
  },
  
  shiftInfo: {
    marginBottom: 16,
  },
  shiftTime: {
    fontSize: 28,
    fontWeight: '800',
    color: '#171717',
    letterSpacing: -1,
    marginBottom: 6,
  },
  shiftRole: {
    fontSize: 16,
    fontWeight: '600',
    color: '#222222',
    marginBottom: 4,
  },
  shiftLocation: {
    fontSize: 14,
    color: '#737373',
    fontWeight: '500',
  },
  
  contextMessage: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#FAFAFA',
    paddingHorizontal: 12,
    paddingVertical: 10,
    borderRadius: 12,
    marginBottom: 20,
  },
  contextText: {
    marginLeft: 8,
    fontSize: 13,
    color: '#424242',
    fontWeight: '600',
  },

  actionRow: {
    marginBottom: 20,
  },
  splitActions: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    gap: 12,
  },
  primaryBtnWrapper: {
    shadowColor: '#FF6B21',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.25,
    shadowRadius: 12,
    elevation: 6,
  },
  gradientBtnFull: {
    paddingVertical: 18,
    borderRadius: 16,
    alignItems: 'center',
    justifyContent: 'center',
  },
  primaryBtn: {
    flex: 1,
    shadowColor: '#FF6B21',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.2,
    shadowRadius: 8,
    elevation: 4,
  },
  gradientBtn: {
    paddingVertical: 16,
    borderRadius: 16,
    alignItems: 'center',
    justifyContent: 'center',
  },
  secondaryBtn: {
    flex: 1,
    backgroundColor: '#F5F5F5',
    paddingVertical: 16,
    borderRadius: 16,
    alignItems: 'center',
    justifyContent: 'center',
  },
  primaryBtnText: {
    color: '#FFFFFF',
    fontSize: 16,
    fontWeight: '700',
    letterSpacing: 0.5,
  },
  secondaryBtnText: {
    color: '#171717',
    fontSize: 16,
    fontWeight: '700',
  },
  btnPressed: {
    transform: [{ scale: 0.97 }],
    opacity: 0.9,
  },

  shiftSummary: {
    alignItems: 'center',
    marginBottom: 16,
  },
  summaryText: {
    fontSize: 13,
    color: '#737373',
    fontWeight: '500',
  },

  timeline: {
    marginTop: 4,
  },
  timelineLabels: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: 8,
  },
  timelineTime: {
    fontSize: 11,
    fontWeight: '700',
    color: '#171717',
  },
  timelineTrackContainer: {
    height: 8,
    justifyContent: 'center',
    marginBottom: 8,
  },
  timelineTrackBg: {
    position: 'absolute',
    left: 0,
    right: 0,
    height: 4,
    backgroundColor: '#F0F0F0',
    borderRadius: 2,
  },
  timelineTrackFill: {
    position: 'absolute',
    left: 0,
    height: 4,
    borderRadius: 2,
  },
  timelineNode: {
    position: 'absolute',
    width: 10,
    height: 10,
    borderRadius: 5,
    backgroundColor: '#FFFFFF',
    borderWidth: 2,
    borderColor: '#E6392F',
    transform: [{ translateX: -5 }],
  },
  timelineNodeBreak: {
    borderColor: '#FFB020',
    backgroundColor: '#FFFFFF',
  },
  timelineLabelsBottom: {
    flexDirection: 'row',
    justifyContent: 'space-between',
  },
  timelineLabel: {
    fontSize: 11,
    color: '#737373',
    fontWeight: '500',
  },

  section: {
    marginBottom: 24,
  },
  sectionHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'baseline',
    marginBottom: 12,
    paddingHorizontal: 4,
  },
  sectionTitle: {
    fontSize: 14,
    fontWeight: '700',
    color: '#737373',
    letterSpacing: 0.5,
  },
  linkText: {
    fontSize: 13,
    fontWeight: '600',
    color: '#E6392F',
  },

  tasksCard: {
    backgroundColor: '#FFFFFF',
    borderRadius: 20,
    overflow: 'hidden',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.03,
    shadowRadius: 8,
    elevation: 2,
  },
  taskItem: {
    flexDirection: 'row',
    alignItems: 'center',
    padding: 16,
  },
  taskText: {
    marginLeft: 12,
    fontSize: 15,
    color: '#171717',
    fontWeight: '500',
  },
  taskDivider: {
    height: 1,
    backgroundColor: '#F5F5F5',
    marginLeft: 50,
  },

  upcomingCard: {
    flexDirection: 'row',
    backgroundColor: '#FFFFFF',
    borderRadius: 20,
    marginBottom: 12,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.03,
    shadowRadius: 8,
    elevation: 2,
    overflow: 'hidden',
  },
  cardPressed: {
    transform: [{ scale: 0.98 }],
    opacity: 0.95,
  },
  accentLine: {
    width: 6,
  },
  upcomingContent: {
    flex: 1,
    padding: 16,
    paddingRight: 8,
  },
  upcomingHeaderRow: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 6,
  },
  upcomingDate: {
    fontSize: 15,
    fontWeight: '700',
    color: '#171717',
    marginRight: 8,
  },
  confirmedBadge: {
    backgroundColor: '#E8F5E9',
    paddingHorizontal: 8,
    paddingVertical: 2,
    borderRadius: 6,
  },
  confirmedText: {
    fontSize: 10,
    fontWeight: '700',
    color: '#2E7D32',
  },
  conflictBadge: {
    backgroundColor: '#FFF0ED',
    paddingHorizontal: 8,
    paddingVertical: 2,
    borderRadius: 6,
  },
  conflictText: {
    fontSize: 10,
    fontWeight: '700',
    color: '#E6392F',
  },
  upcomingRole: {
    fontSize: 14,
    fontWeight: '500',
    color: '#424242',
  },
  chevron: {
    alignSelf: 'center',
    marginRight: 16,
  },
});
